<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 08/11/2018
 * Time: 16.49
 */

namespace App\DataTables\Setting;


use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Zen\Setting\Model\Account;
use App\Zen\User\Permission\Permission;

class AccountDataTable extends BaseDataTable
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
            -> addColumn('action', function ($lease) {
                return $this -> action($lease);
            })
            -> editColumn('currency_id', function ($lease) {
                return '<img src="/vendor/famfamfam/png/' . $lease -> currency -> iso_3166_code . '.png"> ' . $lease -> currency -> iso_4217_code;
            })
            -> rawColumns(['action', 'currency_id']);
    }

    public function query()
    {
        return Account ::with('currency', 'counterparty') -> refactorEntity() -> select('accounts.*');
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
            'counterparty_id' => ['data' => 'counterparty.short_name', 'name' => 'counterparty.short_name', 'title' => trans('master.Counterparty')],
            'account_name'=>['title' => trans('master.Account name')],
            'currency_id' => ['name' => 'currency.iso_4217_code', 'title' => trans('master.Currency')],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'Lease_' . date('YmdHis');
    }

    public
    function action($lease)
    {
        $editPermission = 'edit_account';
        $deletePermission = 'delete_account';
        $editRoute = "/accounts/" . $lease -> id . "/edit";
        $deleteRoute = "/accounts/" . $lease -> id;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        $returnValue = $returnValue . ' <a href="/accounts/copy/' . $lease -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing item"></i></a>';
        return $returnValue;
    }
}