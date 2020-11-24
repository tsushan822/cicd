<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/09/2018
 * Time: 13.45
 */

namespace App\Zen\Report\Model;


use App\Zen\Report\Library\GenerateLibrary;
use Illuminate\Support\Facades\Log;


class ReportLibraryRepository
{
    public function makeReport($reportLibraries = [], $fileFormat = 'xlsx')
    {
        $generateLibrary = new GenerateLibrary();
        foreach($reportLibraries as $report) {
            $generateLibrary -> generate($report);
        }
        $generateLibrary -> setFileFormat($fileFormat) -> makeZip();
        $generateLibrary -> sendEmail() -> deleteFileInBackups();

    }

    public function overrideDates($startDate = null, $endDate = null)
    {
        if($startDate)
            request() -> start_date_new = $startDate;

        if($endDate)
            request() -> end_date_new = $endDate;

        return $this;
    }

}