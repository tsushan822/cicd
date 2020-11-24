<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 13.42
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\LeaseMonthValue;
use Illuminate\Contracts\View\View;

class LeaseMonthEndValueExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        $leases = (new LeaseMonthValue()) -> generateReport();
        $startDate = request() -> end_date;
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.month-value-table-report', compact('leases', 'startDate', 'criteria'));
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
            'T' => $this -> numberFormat(),
            'U' => $this -> numberFormat(),
        ];
    }
}