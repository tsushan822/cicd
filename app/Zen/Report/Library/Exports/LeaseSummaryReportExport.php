<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 13.25
 */

namespace App\Zen\Report\Library\Exports;

use App\Zen\Report\Generate\Lease\LeaseSummaryReport;
use Illuminate\Contracts\View\View;

class LeaseSummaryReportExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        list($total, $dateHeader) = (new LeaseSummaryReport()) -> generateReport();
        $criteria = $this -> makeCriteria();
        $startDate = request() -> end_date;
        return view('reports.lease.table.lease-summary-table-report', compact('total', 'dateHeader', 'criteria', 'startDate'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        $numberOfMonth = request() -> get('number_of_month');

        switch($numberOfMonth){
            case 2:
                return [
                    'B' => $this -> numberFormat(),
                    'C' => $this -> numberFormat(),
                ];
                break;

            case 3:
                return [
                    'B' => $this -> numberFormat(),
                    'C' => $this -> numberFormat(),
                    'D' => $this -> numberFormat(),
                ];
                break;
            default:
                return ['B' => $this -> numberFormat()];

        }

    }
}