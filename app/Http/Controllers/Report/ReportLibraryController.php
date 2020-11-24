<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ReportLibraryMiddleWare;
use App\Http\Requests\Report\MultipleReportEmailRequest;
use App\Jobs\Reports\ReportLibraryJob;
use App\Zen\Report\Library\DownloadCriteriaFromDatabase;
use App\Zen\Report\Model\ReportLibrary;
use App\Zen\Report\Model\ReportLibraryBackground;
use App\Zen\Report\Model\ReportLibraryRepository;
use App\Zen\Setting\Model\AuditTrail;
use App\Zen\System\Service\ModuleAvailabilityService;
use \Exception;
use Illuminate\Support\Facades\Crypt;
use ReflectionClass;

class ReportLibraryController extends Controller
{

    public function __construct()
    {
        $this->middleware(ReportLibraryMiddleWare::class)->except('allReport');
    }

    public function allReport()
    {
        $buttonShow['facility_overview_report'] = ModuleAvailabilityService::checkFacilityOverviewReportAvailability();
        $buttonShow['lease_valuation_report'] = ModuleAvailabilityService::checkLeaseValuationReportAvailability();

        $buttonShow['rou_by_lease_type_report'] = ModuleAvailabilityService::checkRoUByLeaseTypeReportAvailability();
        $buttonShow['addition_to_rou_report'] = ModuleAvailabilityService::checkAdditionToRoUReportAvailability();
        $buttonShow['addition_to_liability_report'] = ModuleAvailabilityService::checkAdditionToLiabilityReportAvailability();
        $buttonShow['lease_summary_report'] = ModuleAvailabilityService::checkLeaseSummaryReportAvailability();
        $buttonShow['ytd_report'] = ModuleAvailabilityService::checkYTDReportAvailability();
        return view('reports.allreports',compact('buttonShow'));
    }
    public function index()
    {
        $reportLibraries = (new DownloadCriteriaFromDatabase()) -> index();
        return view('reports.report-library.index', compact('reportLibraries'));
    }

    public function delete($reportLibraryId)
    {
        $reportLibrary = ReportLibrary ::findOrFail($reportLibraryId);
        try {
            $reportLibrary -> forcedelete();
            flash() -> message(trans('master.The given report criteria is deleted'), trans('master.Success!')) -> overlay();
        } catch (\Exception $e) {
            flash() -> message($e -> getMessage(), trans('master.Access denied!')) -> overlay();
        }
        return redirect(route('report-library.index'));
    }

    public function makeReport($reportLibraryId)
    {
        $returnArray[] = $reportLibraryId;
        (new ReportLibraryRepository()) -> makeReport($returnArray);
        flash() -> overlay(trans('master.The email has been sent'), trans('master.Success!')) -> message();
        return back();
    }

    public function makeMultipleReport(MultipleReportEmailRequest $request)
    {
        $returnArray = $request -> get('reportLibrary');

        $attr = [
            'user_id' => auth() -> id(),
            'file_format' => request() -> get('file_format'),
            'report_libraries' => json_encode($returnArray),
            'start_date' => request() -> get('start_date_new'),
            'end_date' => request() -> get('end_date_new'),
        ];
        $reportLibrary = ReportLibraryBackground ::create($attr);

        ReportLibraryJob::dispatch($reportLibrary);

        flash() -> overlay(trans('master.Your reports are now being processed and will be sent to you ASAP'), trans('master.Success!')) -> message();
        return back();
    }

    /**
     * @param $auditTrailData
     * @param $arrayValue
     * @return string
     */
    public function encodeData($auditTrailData, $arrayValue): string
    {
        $decodedData = json_decode($auditTrailData, true);
        if(is_array($decodedData) && count($decodedData)) {
            foreach($decodedData as $item => $value) {
                if($item == $arrayValue['column_name']) {
                    try {
                        $decodedData[$item] = Crypt ::decrypt($value);
                    } catch (Exception $exception) {
                        $decodedData[$item] = $value;
                    }
                }
            }
        }
        $encodedData = json_encode($decodedData);
        return $encodedData;
    }
}
