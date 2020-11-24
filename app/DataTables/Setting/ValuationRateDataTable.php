<?php

namespace App\DataTables\Setting;

use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\MmDeal\Model\MmRate;
use App\Zen\Setting\Model\Security;
use App\Zen\User\Permission\Permission;

class ValuationRateDataTable extends BaseDataTable
{
    use DataTableActionPermission;
    use Permission;

    /**
     * Build DataTable class.
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            -> addColumn('action', function ($mmRate) {
                return $this -> action($mmRate);
            })
            -> rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     * @param Security $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Security $model)
    {
        return $model -> newQuery() -> select('id', 'isin', 'name', 'date', 'rate_bid', 'rate_average');
    }

    /**
     * Get columns.
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'action' => ['title' => trans('master.Action')],
            'isin' => ['title' => 'ISIN'],
            'name' => ['title' => trans('master.Name')],
            'date' => ['title' => trans('master.Date')],
            'rate_bid' => ['title' => trans('master.Rate Bid')],
            'rate_ask' => ['title' => trans('master.Rate Ask')],
            'rate_average' => ['title' => trans('master.Rate Average')],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected function filename()
    {
        return 'ValuationRate_' . date('YmdHis');
    }

    public function action($valuationRate)
    {
        $editPermission = 'edit_mmrate';
        $deletePermission = 'delete_mmrate';
        $editRoute = "/securities/" . $valuationRate -> id . "/edit";
        $deleteRoute = "/securities/" . $valuationRate -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        $returnValue = $returnValue . ' <a href="/securities/copy/' . $valuationRate -> id . '"><i 
            class="fas fa-copy edit_fontawesome_icon" title="Copy existing rate"></i></a>';
        return $returnValue;

    }
}
