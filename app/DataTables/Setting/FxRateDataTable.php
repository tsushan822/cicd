<?php

namespace App\DataTables\Setting;

use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\FxRate;
use App\Zen\User\Permission\Permission;

class FxRateDataTable extends BaseDataTable
{
    use Permission;
    use DataTableActionPermission;

    /**
     * Build DataTable class.
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            -> addColumn('action', function ($fxRate) {
                return $this -> action($fxRate);
            })
            -> editColumn('direct_quote', function ($fxRate) {
                return $fxRate -> direct_quote == 0 ? "Indirect" : $fxRate -> direct_quote == 1 ? "Imported" : 'Calculated';
            })
            -> editColumn('ccy_base_id', function ($fxRate) {
                return '<img src="/vendor/famfamfam/png/' . $fxRate -> baseCurrency -> iso_3166_code . '.png"> ' . $fxRate -> baseCurrency -> iso_4217_code;
            })
            -> editColumn('ccy_cross_id', function ($fxRate) {
                return '<img src="/vendor/famfamfam/png/' . $fxRate -> crossCurrency -> iso_3166_code . '.png"> ' . $fxRate -> crossCurrency -> iso_4217_code;
            })
            -> rawColumns(['action', 'ccy_cross_id', 'ccy_base_id']);
    }


    public function query()
    {
        return FxRate :: with('baseCurrency') -> with('crossCurrency') -> select('fx_rates.*');
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
            'date' => ['title' => trans('master.Date')],
            'ccy_base_id' => ['name' => 'baseCurrency.iso_4217_code', 'title' => trans('master.Base Currency')],
            'ccy_cross_id' => ['name' => 'crossCurrency.iso_4217_code', 'title' => trans('master.Cross currency')],
            'rate_bid' => ['title' => trans('master.Rate')],
            'direct_quote' => ['title' => trans('master.Source')],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected function filename()
    {
        return 'FxRate_' . date('YmdHis');
    }

    public function action($fxRate)
    {
        $editPermission = 'edit_fxrate';
        $deletePermission = 'delete_fxrate';
        $createPermission = 'create_fxrate';
        $editRoute = "/fxrates/" . $fxRate -> id . "/edit";
        $deleteRoute = "/fxrates/" . $fxRate -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);

        if($this -> checkAllowAccessWithoutException($createPermission))
            $returnValue = $returnValue . ' <a href="/fxrates/copy/' . $fxRate -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing item"></i></a>';

        return $returnValue;
    }
}
