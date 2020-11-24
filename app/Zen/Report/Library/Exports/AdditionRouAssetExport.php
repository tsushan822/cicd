<?php


namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\AdditionROUAsset;
use Illuminate\Contracts\View\View;

class AdditionRouAssetExport extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        $leases = (new AdditionRouAsset) -> generateReport();
        $startDate = request() -> end_date;
        $criteria = $this -> makeCriteria();
        return view('reports.lease.table.additions-rou-asset-table-report', compact('leases', 'startDate','criteria'));
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {

        return [
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