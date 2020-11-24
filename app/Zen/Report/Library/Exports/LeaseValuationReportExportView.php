<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 13.25
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\LeasePaymentReport;
use App\Zen\Report\Generate\Lease\LeaseValuationReport;
use Illuminate\Contracts\View\View;

class LeaseValuationReportExportView extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        list($startDate, $returnData) = (new LeaseValuationReport()) -> generateReport();
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.lease-valuation-report', compact('returnData', 'startDate','criteria'));
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
            'Q' => $this -> numberFormat(),
            'R' => $this -> numberFormat(),
        ];
    }
}