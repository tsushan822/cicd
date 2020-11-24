<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 12.46
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\LeaseChangeReport;
use Illuminate\Contracts\View\View;

class LeaseChangeReportExportView extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        $leaseFlows = (new LeaseChangeReport()) -> generateReport();
        $startDate = request() -> start_date;
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.change-lease-table-report', compact('leaseFlows', 'startDate', 'criteria'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {

        return [
            'H' => $this -> numberFormat(),
            'I' => $this -> numberFormat(),
            'J' => $this -> numberFormat(),
            'K' => $this -> numberFormat(),
            'L' => $this -> numberFormat(),
            'M' => $this -> numberFormat(),
            'N' => $this -> numberFormat(),
            'O' => $this -> numberFormat(),
            'P' => $this -> numberFormat(),
        ];
    }
}