<?php


namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\LeaseFacilityOverviewReport;
use Illuminate\Contracts\View\View;

class LeaseFacilityOverviewReportExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        list($startDate, $returnData) = (new LeaseFacilityOverviewReport()) -> generateReport();
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.facility-overview-table-report', compact('returnData', 'startDate','criteria'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {

        return [
            'K' => $this -> numberFormat(),
            'L' => $this -> numberFormat(),
            'M' => $this -> numberFormat(),
            'N' => $this -> numberFormat(),
            'O' => $this -> numberFormat(),
            'P' => $this -> numberFormat(),
            'Q' => $this -> numberFormat(),
            'S' => $this -> numberFormat(),
            'U' => $this -> numberFormat(),
            'V' => $this -> numberFormat(),
            'W' => $this -> numberFormat(),
            'X' => $this -> numberFormat(),
            'Y' => $this -> numberFormat(),
            'Z' => $this -> numberFormat(),
            'AA' => $this -> numberFormat(),
            'AC' => $this -> numberFormat(),
            'AE' => $this -> numberFormat(),
        ];
    }
}