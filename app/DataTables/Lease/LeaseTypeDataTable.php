<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/11/2018
 * Time: 14.49
 */

namespace App\DataTables\Lease;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\User\Permission\Permission;

class LeaseTypeDataTable extends BaseDataTable
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
            -> addColumn('action', function ($leaseType) {
                return $this -> action($leaseType);
            })
            -> editColumn('business_day_convention_id', function ($leaseType) {
                return optional($leaseType -> businessDayConvention) -> convention;
            })
            -> rawColumns(['action']);
    }

    public function query()
    {

        return LeaseType ::select('lease_types.*');
    }


    /**
     * Get columns.
     * @return array
     */
    protected
    function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            'action' => ['title' => trans('master.Action')],
            'type'=> ['title' => trans('master.Lease type name')],
            'interest_calculation_method' => ['title' => trans('master.Interest calculation method')],
            'description'=> ['title' => trans('master.Description')],
            'lease_type_item'=> ['title' => trans('master.Lease type')],
            'business_day_convention_id'=> ['title' => trans('master.Business day convention')],
            'payment_type'=> ['title' => trans('master.Payment type')],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'LeaseType_' . date('YmdHis');
    }

    public
    function action($leaseType)
    {
        $editPermission = 'edit_lease_type';
        $createPermission = 'create_lease_type';
        $deletePermission = 'delete_lease_type';
        $editRoute = "/lease-types/" . $leaseType -> id . "/edit";
        $deleteRoute = "/lease-types/" . $leaseType -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        $returnValue = $this->checkAllowAccessWithoutException($createPermission) ? $returnValue .' <a href="/lease-types/copy/' . $leaseType -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing type"></i></a>' : $returnValue;
        return $returnValue;
    }
}