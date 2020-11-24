<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/10/2018
 * Time: 14.25
 */

namespace App\Zen\Report\Library;


use App\Exceptions\CustomException;
use App\Mail\ReportGenerateMail;
use App\Zen\Report\Library\Exports\AdditionLeaseLiabilityExport;
use App\Zen\Report\Library\Exports\AdditionRouAssetExport;
use App\Zen\Report\Library\Exports\LeaseChangeReportExportView;
use App\Zen\Report\Library\Exports\LeaseFacilityOverviewReportExport;
use App\Zen\Report\Library\Exports\LeasePaymentReportExport;
use App\Zen\Report\Library\Exports\LeaseRoUAssetByType;
use App\Zen\Report\Library\Exports\LeaseSummaryReportExport;
use App\Zen\Report\Library\Exports\LeaseSummaryYTDReportExport;
use App\Zen\Report\Library\Exports\LeaseValuationReportExportView;
use App\Zen\Report\Model\ReportLibrary;
use App\Zen\Report\Library\Exports\LeaseMonthEndValueExport;
use App\Zen\Report\Library\Exports\NotesMaturityReportExportView;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class GenerateLibrary
{
    protected $archiveFile;

    protected $fileFormat = 'xlsx';

    protected $storageFolder;

    /**
     * @param $reportLibraryId
     * @throws CustomException
     */
    public function generate($reportLibraryId)
    {


        $folder = Storage ::disk('tenant') -> getAdapter() -> getPathPrefix();
        config(['filesystems.disks.report_backup.root' => $folder . 'ReportLibrary/' . auth() -> id()]);
        $this -> storageFolder = Storage ::disk('report_backup') -> getAdapter() -> getPathPrefix();


        $reportLibrary = ReportLibrary ::findOrFail($reportLibraryId);
        $reportName = $this -> reportName($reportLibrary);

        switch($reportLibrary -> report_name){

            case 'Notes Maturity Report':
                Excel ::store(new NotesMaturityReportExportView($reportLibrary), $reportName, 'report_backup');
                break;


            case 'Lease Changes Report':
                Excel ::store(new LeaseChangeReportExportView($reportLibrary), $reportName, 'report_backup');
                break;

            case 'RoU Asset by Lease Type':
                Excel ::store(new LeaseRoUAssetByType($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Lease Payments Report':
                Excel ::store(new LeasePaymentReportExport($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Lease Valuation Report':
                Excel ::store(new LeaseValuationReportExportView($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Lease Summary Report':
                Excel ::store(new LeaseSummaryReportExport($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Lease Summary Report YTD':
                Excel ::store(new LeaseSummaryYTDReportExport($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Lease Month End Value':
                Excel ::store(new LeaseMonthEndValueExport($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Addition Lease Liability':
                Excel ::store(new AdditionLeaseLiabilityExport($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Addition ROU Asset':
                Excel ::store(new AdditionRouAssetExport($reportLibrary), $reportName, 'report_backup');
                break;

            case 'Lease Facility Overview Report':
                Excel ::store(new LeaseFacilityOverviewReportExport($reportLibrary), $reportName, 'report_backup');
                break;

            default:
                throw new CustomException(trans('master.Problem with report automation please contact administrator'));
                break;
        }
    }

    public function reportName($reportLibrary)
    {

        return $reportLibrary -> custom_report_name . '.' . $this -> getFileFormat();
    }

    /**
     * @return string
     */
    public function getFileFormat(): string
    {
        return $this -> fileFormat;
    }

    /**
     * @param string $fileFormat
     * @return $this
     */
    public function setFileFormat(string $fileFormat)
    {
        $this -> fileFormat = $fileFormat;
        return $this;
    }

    public function className()
    {
        switch($this -> getFileFormat()){
            case 'xlsx':
                return \Maatwebsite\Excel\Excel::XLSX;
                break;
            case 'csv':
                return \Maatwebsite\Excel\Excel::CSV;
                break;
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws CustomException
     * @throws Exception
     */
    public function makeZip()
    {
        /*$archiveFile = $this -> storageFolder . time() . "_report_library.zip";
        $files = glob($this -> storageFolder . '*');
        Zipper ::make($archiveFile) -> add($files) -> close();
        $this -> setArchiveFile($archiveFile);*/

        $zip = new ZipArchive;
        $fileName = $this -> storageFolder . time() . "_report_library.zip";
        if($zip -> open($fileName, ZipArchive::CREATE) === TRUE) {
            //$files = File::files(public_path('myFiles'));
            $files = glob($this -> storageFolder . '*');
            foreach($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip -> addFile($value, $relativeNameInZipFile);
            }

            $zip -> close();
        }
        $this -> setArchiveFile($fileName);
    }

    /**
     * @param mixed $archiveFile
     * @return $this
     */
    public
    function setArchiveFile($archiveFile)
    {
        $this -> archiveFile = $archiveFile;
        return $this;
    }

    /** @return mixed
     */
    public
    function getArchiveFile()
    {
        return $this -> archiveFile;
    }

    /**
     * @return $this
     * @throws CustomException
     */
    public function sendEmail()
    {
        $userEmail = \auth() -> user() -> email;
        $archiveFile = $this -> getArchiveFile();
        try {
            Mail ::to($userEmail) -> send(new ReportGenerateMail($archiveFile));
        } catch (Exception $exception) {
            throw new CustomException($exception -> getMessage());
        }

        return $this;
    }

    /**
     * @return $this
     * @throws CustomException
     */

    public function deleteFileInBackups()
    {
        try {
            $files = Storage ::disk('tenant') -> allFiles();
            Storage ::disk('tenant') -> delete($files);
        } catch (Exception $exception) {
            throw new CustomException($exception -> getMessage());
        }
        return $this;
    }

    /**
     * @return mixed
     * @throws CustomException
     */
    public function backCheck()
    {
        $this -> checkCriteria();

        config(['filesystems.disks.report_backup.root' => storage_path('Backups/temporary/' . env('CLIENT_NAME') . '/ReportLibrary/' . auth() -> id())]);

        $this -> storageFolder = "Backups/temporary/" . env('CLIENT_NAME') . '/ReportLibrary/' . auth() -> id();

    }

    public function reportNameHistory($voucherHistory)
    {
        return $voucherHistory -> voucher_name . '.' . $this -> getFileFormat();
    }

    private function getWriterType()
    {
        switch($this -> fileFormat){
            case 'CSV':
                return \Maatwebsite\Excel\Excel::CSV;
            case 'XLS':
            default:
                return \Maatwebsite\Excel\Excel::XLS;
        }
    }
}