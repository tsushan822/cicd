<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 14/11/2018
 * Time: 11.59
 */

namespace App\DataTables\Report;


use App\DataTables\BaseDataTable;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Lease\Service\LeaseReportService;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\Currency\CurrencyService;

class LeasePaymentDataTable extends BaseDataTable
{

    /**
     * Build DataTable class.
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        set_time_limit(100);
        return datatables() -> of($query)
            -> editColumn('total_payment', function ($leaseFlow) {
                return mYFormat($leaseFlow -> fixed_payment + $leaseFlow -> fees);
            })
            -> editColumn('cost_center_id', function ($leaseFlow) {
                return optional($leaseFlow -> lease -> costCenter) -> short_name;
            })
            -> editColumn('total_payment_base_currency', function ($leaseFlow) {
                return mYFormat($this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fixed_payment + $leaseFlow -> fees, $leaseFlow -> payment_date));
            })
            -> editColumn('fixed_payment', function ($leaseFlow) {
                return mYFormat($leaseFlow -> fixed_payment);
            })
            -> editColumn('fixed_payment_base_currency', function ($leaseFlow) {
                return mYFormat($this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fixed_payment, $leaseFlow -> payment_date));
            })
            -> editColumn('fees', function ($leaseFlow) {
                return mYFormat($leaseFlow -> fees);
            })
            -> editColumn('fees_base_currency', function ($leaseFlow) {
                return mYFormat($this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fees, $leaseFlow -> payment_date));
            })
            -> editColumn('repayment', function ($leaseFlow) {
                $leaseFlow -> repayment = LeaseFlowService ::calculateRepayment($leaseFlow);
                return mYFormat($leaseFlow -> repayment);
            })
            -> editColumn('currency_id', function ($leaseFlow) {
                return '<img src="/vendor/famfamfam/png/' . $leaseFlow -> lease -> currency -> iso_3166_code . '.png"> ' . $leaseFlow -> lease -> currency -> iso_4217_code;
            })
            -> editColumn('lease_id', function ($leaseFlow) {
                return '<a href="/leases/' . $leaseFlow -> lease_id . '/edit" target="_blank"> ' . $leaseFlow -> lease_id . '</a>';
            })
            -> editColumn('repayment_base_currency', function ($leaseFlow) {
                return mYFormat($this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> repayment, $leaseFlow -> payment_date));
            })
            -> editColumn('interest_cost', function ($leaseFlow) {
                return mYFormat($leaseFlow -> interest_cost);
            })
            -> editColumn('interest_cost_base_currency', function ($leaseFlow) {
                return mYFormat($this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> interest_cost, $leaseFlow -> payment_date));
            })
            -> rawColumns(['currency_id', 'lease_id']);
    }

    public function query()
    {
        $startDate = request() -> start_date;
        $endDate = request() -> end_date;

        $leaseIdArray = Lease ::reportable() -> pluck('id') -> toArray();
        return LeaseFlow ::with('lease.entity', 'lease.currency', 'lease.leaseType', 'lease.portfolio', 'lease.costCenter') -> whereBetween('payment_date', [$startDate, $endDate]) -> whereIn('lease_id', $leaseIdArray) -> select('lease_flows.*');

    }

    /**
     * Optional method if you want to use html builder.
     * @return \Yajra\DataTables\Html\Builder
     */
    public
    function html()
    {
        return $this -> builder()
            -> columns($this -> getColumns())
            -> minifiedAjax($url = '', $script = null, $data = [
                'start_date' => request('start_date'),
                'end_date' => request('end_date')
            ])
            -> drawCallback('function( settings ) {
                    var api = this.api();
                    $(api.column(7).footer()).html(api.column([7]).data().sum());
                    $(api.column(8).footer()).html(api.column([8]).data().sum());
                    $(api.column(9).footer()).html(api.column([9]).data().sum());
                    $(api.column(10).footer()).html(api.column([10]).data().sum());
                    $(api.column(11).footer()).html(api.column([11]).data().sum());
                    $(api.column(12).footer()).html(api.column([12]).data().sum());
                    $(api.column(13).footer()).html(api.column([13]).data().sum());
                    $(api.column(14).footer()).html(api.column([14]).data().sum());
                    $(api.column(15).footer()).html(api.column([15]).data().sum());
                    $(api.column(16).footer()).html(api.column([16]).data().sum());
                    }')
            -> parameters([
                'footer' => true,
                'dom' => 'Bfrtip',
                'buttons' => [['extend' => 'excelHtml5', 'footer' => true], ['extend' => 'csvHtml5', 'footer' => true],
                    'print', ['extend' => 'copyHtml5', 'footer' => true], ['extend' => 'pdfHtml5', 'footer' => true, 'orientation' => 'landscape', 'pageSize' => 'A3'], 'pageLength'],
                'pageLength' => 50,
                "aLengthMenu" => [[25, 50, 100, 200, 500, 1000, 2000, -1], [25, 50, 100, 200, 500, 1000, 2000, "All"]],
            ]);
    }

    /**
     * Get columns.
     * @return array
     */
    protected
    function getColumns()
    {
        return [
            'lease_id' => ['data' => 'lease_id', 'name' => 'lease_id', 'title' => 'Lease ID'],
            'entity_id' => ['data' => 'lease.entity.short_name', 'name' => 'lease.entity.short_name', 'title' => 'Entity'],
            'payment_date',
            'lease_type_id' => ['data' => 'lease.lease_type.type', 'name' => 'lease.leaseType.type', 'title' => 'Lease Type'],
            'portfolio_id' => ['data' => 'lease.portfolio.name', 'name' => 'lease.portfolio.name', 'title' => 'Portfolio'],
            'cost_center_id' => ['name' => 'lease.costCenter.short_name', 'title' => 'Cost Center'],
            'currency_id' => ['name' => 'lease.currency.iso_4217_code', 'title' => 'Currency'],
            'total_payment' => ['orderable' => false, 'searchable' => false],
            'total_payment_base_currency' => ['orderable' => false, 'searchable' => false],
            'fixed_payment',
            'fixed_payment_base_currency' => ['orderable' => false, 'searchable' => false],
            'fees',
            'fees_base_currency' => ['orderable' => false, 'searchable' => false],
            'repayment' => ['orderable' => false, 'searchable' => false],
            'repayment_base_currency' => ['orderable' => false, 'searchable' => false],
            'interest_cost',
            'interest_cost_base_currency' => ['orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'Lease_Payment_Report_' . date('YmdHis');
    }

    public function checkBaseCurrencyAndConvert($lease, $amount, $date = null)
    {
        $accountingDate = $date ?: $lease -> effective_date;
        $baseCurrency = $this -> getCurrencyLease($lease -> entity_id);
        if($amount && $baseCurrency -> id != $lease -> currency_id)
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $accountingDate, $baseCurrency, $lease -> currency);

        return $amount;
    }

    public function getCurrencyLease($entityId = null)
    {
        if(request() -> get('currency_id')) {
            return Currency ::findOrFail(request() -> get('currency_id'));
        }

        return CurrencyService ::getCompanyBaseCurrency($entityId);
    }

}