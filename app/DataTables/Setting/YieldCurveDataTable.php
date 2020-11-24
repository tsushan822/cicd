<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/11/2018
 * Time: 14.35
 */

namespace App\DataTables\Setting;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\MmDeal\Model\YieldCurve;
use App\Zen\User\Permission\Permission;

class YieldCurveDataTable extends BaseDataTable
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
        return datatables() -> of($query)
            -> addColumn('action', function ($yieldCurve) {
                return $this -> action($yieldCurve);
            })
            -> editColumn('currency_id', function ($yieldCurve) {
                return '<img src="/vendor/famfamfam/png/' . $yieldCurve -> currency -> iso_3166_code . '.png"> ' . $yieldCurve -> currency -> iso_4217_code;
            })
            -> rawColumns(['action', 'currency_id']);
    }

    public function query()
    {
        return YieldCurve ::with('currency') -> select('yield_curves.*');
    }

    /**
     * Get columns.
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'id', 'title' => trans('master.ID')],
            'action' => ['title' => trans('master.Action')],
            'name' => ['title' => trans('master.Name')],
            'currency_id' => ['title' => trans('master.Currency')],
        ];
    }

    public
    function action($yieldCurve)
    {
        $editPermission = 'is_superadmin';
        $deletePermission = 'is_superadmin';
        $editRoute = "/yieldcurves/" . $yieldCurve -> id . "/edit";
        $deleteRoute = "/yieldcurves/" . $yieldCurve -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        return $returnValue;
    }
}