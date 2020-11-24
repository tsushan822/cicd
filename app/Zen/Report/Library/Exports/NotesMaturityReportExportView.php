<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 11.37
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\NotesMaturityTable;
use Illuminate\Contracts\View\View;

class NotesMaturityReportExportView extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        list($returnData, $startDate) = (new NotesMaturityTable()) -> generateReport();
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.notes-maturity-table-report', compact('returnData',
            'startDate', 'criteria'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {

        return [
            'C' => $this -> numberFormat(),
            'D' => $this -> numberFormat(),
            'E' => $this -> numberFormat(),
            'F' => $this -> numberFormat(),
            'G' => $this -> numberFormat(),
            'H' => $this -> numberFormat(),
            'I' => $this -> numberFormat(),
            'J' => $this -> numberFormat(),
        ];
    }
}