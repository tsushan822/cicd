<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/11/2018
 * Time: 16.02
 */

namespace App\DataTables\Lease;

use App\DataTables\BaseDataTable;
use App\DataTables\DataTableActionPermission;
use App\Scopes\LeaseAccountableScope;
use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Service\AdminSettingService;
use App\Zen\User\Permission\Permission;

class LeaseDataTable extends BaseDataTable
{
    use Permission;
    use DataTableActionPermission;


    /**
     * @param $query
     * @return mixed
     * @throws \Exception
     */
    public function dataTable($query)
    {
        return datatables() -> of($query)
            -> addColumn('action', function ($lease) {
                return $this -> action($lease);
            })
            -> editColumn('total_lease', function ($lease) {
                return mYFormat($lease -> total_lease);
            })
            -> addColumn('cost_center_id', function ($lease) {
                if(app('costCenterSplitAdmin') && $lease -> cost_center_split)
                    return trans('master.Cost center split on');

                return optional($lease -> costCenter) -> short_name;
            })
            -> editColumn('currency_id', function ($lease) {
                return '<img src="/vendor/famfamfam/png/' . $lease -> currency -> iso_3166_code . '.png"> ' . $lease -> currency -> iso_4217_code;
            })
            -> editColumn('non_accountable', function ($lease) {
                return '<i class="' . getLargeCheckBox(!$lease -> non_accountable) . '">' . '<span style="font-size:1px">' . !$lease -> non_accountable . '</span>';
            })
            -> rawColumns(['action', 'currency_id', 'non_accountable']);
    }

    public function query()
    {
        return $this -> getQuery() -> select('leases.*');
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
            'action' => ['title' => trans('master.Action'), 'exportable' => false],
            'customer_reference' => ['data' => 'customer_reference', 'name' => 'customer_reference', 'title' => trans('master.Customer reference')],
            'entity_id' => ['data' => 'entity.short_name', 'name' => 'entity.short_name', 'title' => trans('master.Entity')],
            'counterparty_id' => ['data' => 'counterparty.short_name', 'name' => 'counterparty.short_name', 'title' => trans('master.Counterparty')],
            'lease_type_id' => ['data' => 'lease_type.type', 'name' => 'leaseType.type', 'title' => trans('master.Lease type')],
            'cost_center_id' => ['name' => 'costCenter.short_name', 'title' => trans('master.Cost center')],
            'portfolio_id' => ['data' => 'portfolio.name', 'name' => 'portfolio.name', 'title' => trans('master.Portfolio')],
            'total_lease' => ['data' => 'total_lease', 'name' => 'total_lease', 'title' => trans('master.Total lease payment')],
            'currency_id' => ['name' => 'currency.iso_4217_code', 'title' => trans('master.Currency')],
            'lease_rate' => ['title' => trans('master.Interest rate')],
            'effective_date' => ['data' => 'effective_date', 'name' => 'effective_date', 'title' => trans('master.Start date')],
            'maturity_date' => ['data' => 'maturity_date', 'name' => 'maturity_date', 'title' => trans('master.Maturity date')],
            'non_accountable' => ['title' => trans('master.Active'), 'exportable' => false],
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
        $editPermission = 'edit_lease';
        $deletePermission = 'delete_lease';
        $editRoute = "/leases/" . $lease -> id . "/edit";
        $deleteRoute = AdminSettingService ::dateFreezeDate($lease -> effective_date) ? "/leases/" . $lease -> id : null;
        $returnValue = $this -> actionPermission($editPermission, $deletePermission, $editRoute, $deleteRoute);
        $returnValue = $returnValue . ' <a href="/leases/copy/' . $lease -> id . '"><i class="fas fa-copy edit_fontawesome_icon" title="Copy existing deals"></i></a>';
        return $returnValue;
    }

    public function getQuery()
    {
        if($this -> isArchived())
            return Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> with('currency', 'entity', 'counterparty', 'portfolio', 'costCenter', 'leaseType', 'leaseExtension')
                -> refactorEntity() -> archive();

        return Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> with('currency', 'entity', 'counterparty', 'portfolio', 'costCenter', 'leaseType', 'leaseExtension')
            -> refactorEntity() -> nonArchive();
    }

    public function getNumber()
    {
        return $this -> getQuery() -> get() -> count();
    }

    /**
     * Optional method if you want to use html builder.
     * @return \Yajra\DataTables\Html\Builder
     */
    public
    function html()
    {
        //translation varaibles
        $locale = \App ::getLocale();
        $allTranslation = trans('master.All');
        return $this -> builder()
            -> columns($this -> getColumns())
            -> minifiedAjax()
            -> createdRow('function ( row, data, index ) {
            if(data.non_accountable == null)
            $(row).addClass(\'highlight5\');
            }')
            -> parameters([
                'buttons' => [
                    'extend' => 'collection',
                    'text' => __('Export'),
                    'buttons' => [
                        [
                            'extend' => 'csvHtml5',
                            'text' => __('CSV'),
                            'filename' => $this -> filename(),
                            'exportOptions' => ['modifier' => ['selected' => true], 'columns' => [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]]
                        ],
                        [
                            'extend' => 'excelHtml5',
                            'text' => __('Excel'),
                            'filename' => $this -> filename(),
                            'title' => '',
                            'exportOptions' => ['modifier' => ['selected' => true], 'columns' => [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]]
                        ],
                        ['extend' => 'pageLength',]
                    ]
                ],
                'oLanguage' => ['sUrl' => "/languages/dataTables.$locale.txt"],
                'dom' => 'Bfrtip',
                'pageLength' => 50,
                'stateSave' => false,
                'responsive' => true,
                "autoWidth" => false,
                "aLengthMenu" => [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, $allTranslation]],
                "order" => $this -> setOrderBy(),
            ]);
    }
}