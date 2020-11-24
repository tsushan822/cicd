<?php

namespace App\DataTables\Setting;

use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\User\Permission\AllowedEntity;
use App\Zen\User\Permission\Permission;

class CounterpartyDataTable extends BaseDataTable
{
    use Permission;
    use DataTableActionPermission;
    use AllowedEntity;

    /**
     * Build DataTable class.
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            -> addColumn('action', function ($counterparty) {
                return $this -> action($counterparty);
            })
            -> editColumn('is_entity', function ($counterparty) {
                return '<i class="' . getLargeCheckBox($counterparty -> is_entity) . '">'. '<span style="font-size:1px">' . $counterparty -> is_entity . '</span>';
            })
            -> editColumn('currency_id', function ($counterparty) {
                return '<img src="/vendor/famfamfam/png/' . $counterparty -> currency -> iso_3166_code . '.png"> ' . $counterparty -> currency -> iso_4217_code;
            })
            -> editColumn('is_counterparty', function ($counterparty) {
                return '<i class="' . getLargeCheckBox($counterparty -> is_counterparty) . '">' . '<span style="font-size:1px">' . $counterparty -> is_counterparty . '</span>';
            })
            -> rawColumns(['action', 'is_internal', 'is_external', 'is_counterparty', 'is_entity', 'currency_id']);
    }

    public function query()
    {
        $entityId = $this -> getAllowedEntity();
        return Counterparty :: whereIn('id', $entityId) -> OrWhere(function ($query) use ($entityId) {
            $query -> where('is_counterparty', 1) -> where('is_entity', '<>', 1);
        }) -> with('currency') -> select('counterparties.*');
    }

    /**
     * Get columns.
     * @return array
     */
    protected
    function getColumns()
    {
        return ['id',
            'action',
            'short_name' => ['title' => trans('master.Short name'), 'data' => 'short_name', 'name' => 'short_name'],
            'long_name' => ['title' => trans('master.Long name'), 'data' => 'long_name', 'name' => 'long_name'],
            'currency_id' => ['name' => 'currency.iso_4217_code', 'title' => trans('master.Currency')],
            'is_entity' => ['title' => trans('master.Entity'), 'data' => 'is_entity'],
            'is_counterparty' => ['title' => trans('master.Counterparty')],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'Counterparty_' . date('YmdHis');
    }

    public
    function action($model)
    {
        $editRoute = "/counterparties/" . $model -> id . "/edit";
        $deleteRoute = "/counterparties/" . $model -> id;
        $editPermission = 'edit_counterparty';
        $deletePermission = 'delete_counterparty';
        $createPermission = 'create_counterparty';
        $returnValue = '';
        $returnValue = $this -> checkAllowAccessWithoutException($editPermission) ?
            $returnValue . ' <a href="' . $editRoute . '"><i class="fas fa-pen-square edit_fontawesome_icon" title="Show/Edit the item"></i></a>' :
            $returnValue . ' <a href="' . $editRoute . '"><i class="fas fa-eye edit_fontawesome_icon" title="Show the item"></i></a>';
        if($model -> is_parent_company) {
            $returnValue = $returnValue . '<i class="far fa-flag delete_fontawesome_icon" title="Is Parent Company" style="color: #0166C7"></i>';
        } else {
            $returnValue = $this -> checkAllowAccessWithoutException($deletePermission) ? $returnValue . ' <a href="' . $deleteRoute . '"><i class="far fa-minus-square delete_fontawesome_icon" title="Delete the item"></i></a>' : $returnValue . '';
        }
        if($this -> checkAllowAccessWithoutException($createPermission))
            $returnValue = $returnValue . ' <a href="/counterparties/copy/' . $model -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing deals"></i></a>';
        return $returnValue;

    }

}
