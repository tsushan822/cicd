<?php


namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\LeaseSummaryReportYTD;
use App\Zen\Setting\Model\Counterparty;
use Illuminate\Contracts\View\View;

class LeaseSummaryYTDReportExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        list($total, $dateHeader) = (new LeaseSummaryReportYTD()) -> generateReport();
        $criteria = $this -> makeCriteria();
        $startDate = request() -> end_date;
        return view('reports.lease.table.lease-summary-ytd-table-report', compact('total', 'dateHeader', 'criteria', 'startDate'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        if(request() -> get('entity_id')) {
            return ['B' => $this -> numberFormat()];
        }
        $entityCount = Counterparty ::has('leases') -> allowedEntity() -> count();
        $returnArray = [];
        $i = 1;

        foreach(range('B', 'ZZ') as $column) {
            $returnArray[$column] = $this -> numberFormat();
            if($i == $entityCount) {
                break;
            }
            $i++;
        }
        return $returnArray;

    }
}