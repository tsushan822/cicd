<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 13.25
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\LeasePaymentReport;
use Illuminate\Contracts\View\View;

class LeasePaymentReportExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        $leaseFlows = (new LeasePaymentReport()) -> generateReport();
        $startDate = request() -> start_date;
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.month-payment-table-report', compact('leaseFlows', 'startDate','criteria'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {

        return [
            'I' => $this -> numberFormat(),
            'J' => $this -> numberFormat(),
            'K' => $this -> numberFormat(),
            'L' => $this -> numberFormat(),
            'M' => $this -> numberFormat(),
            'N' => $this -> numberFormat(),
            'O' => $this -> numberFormat(),
            'P' => $this -> numberFormat(),
            'Q' => $this -> numberFormat(),
            'R' => $this -> numberFormat(),
            'S' => $this -> numberFormat(),
        ];
    }
}