<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/11/2018
 * Time: 13.38
 */

namespace App\DataTables\Setting;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\User\Permission\Permission;

class CostCenterDataTable extends BaseDataTable
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
            -> addColumn('action', function ($costCenter) {
                return $this -> action($costCenter);
            })
            -> rawColumns(['action']);
    }

    public function query()
    {
        return CostCenter :: with('portfolio') -> get();
    }

    /**
     * Get columns.
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'id', 'title' => trans('master.Id')],
            'action' => ['title' => trans('master.Action')],
            'short_name' => ['data' => 'short_name', 'name' => 'short_name', 'title' => trans('master.Short name')],
            'long_name' => ['data' => 'long_name', 'name' => 'long_name', 'title' => trans('master.Long name')],
        ];
    }

    public
    function action($costCenter)
    {
        $editPermission = 'edit_costcenter';
        $deletePermission = 'delete_costcenter';
        $createPermission = 'create_costcenter';
        $editRoute = "/costcenters/" . $costCenter -> id . "/edit";
        $deleteRoute = "/costcenters/" . $costCenter -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        if($this -> checkAllowAccessWithoutException($createPermission))
            $returnValue = $returnValue . ' <a href="/costcenters/copy/' . $costCenter -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing costcenter"></i></a>';
        return $returnValue;
    }
}