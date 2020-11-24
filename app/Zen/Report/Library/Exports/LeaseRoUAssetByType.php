<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 2019-03-26
 * Time: 12:00
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Generate\Lease\RoUAssetByLeaseType;
use Illuminate\Contracts\View\View;

class LeaseRoUAssetByType extends ReportExportView
{

    /**
     * @return View
     */
    public function view(): View
    {
        $criteria = $this -> makeCriteria();
        list($total, $dateHeader) = (new RoUAssetByLeaseType()) -> generateReport();
        $startDate = request() -> end_date;
        return view('reports.lease.table.rou-asset-table-report', compact('total', 'dateHeader', 'criteria', 'startDate'));
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