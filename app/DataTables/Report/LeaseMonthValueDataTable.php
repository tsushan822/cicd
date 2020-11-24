<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 14/11/2018
 * Time: 14.48
 */

namespace App\DataTables\Report;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Lease\Service\LeaseService;
use App\Zen\Report\Generate\Lease\Traits\CalculateMonthEndBalance;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use App\Zen\Setting\Service\Currency\CurrencyService;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class LeaseMonthValueDataTable extends DataTable
{
    use CalculateMonthEndBalance;

    /**
     * Build DataTable class.
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $accountingDate = Carbon ::parse(request() -> end_date) -> endOfMonth() -> toDateString();
        $accountingDatePlusYear = Carbon ::parse($accountingDate) -> addYear() -> toDateString();

        return datatables() -> of($query)
            -> editColumn('cost_center_id', function ($lease) {
                return optional($lease -> costCenter) -> short_name;
            })
            -> editColumn('report_date', function () {
                return request('end_date');
            })
            -> editColumn('currency_id', function ($lease) {
                return '<img src="/vendor/famfamfam/png/' . $lease -> currency -> iso_3166_code . '.png"> ' . $lease -> currency -> iso_4217_code;
            })
            /*-> editColumn('total_liability_amount_in_currency', function ($lease) use ($accountingDate, $accountingDatePlusYear) {
                $lastFlowPresent = LeaseFlowService ::leaseFlowPresent($lease, $accountingDate);
                if(!$lastFlowPresent) {
                    $lastFlowPresentWithOpening = LeaseFlowService ::leaseFlowPresentWithOpening($lease, Carbon ::parse($accountingDate) -> subDay() -> toDateString());
                    $lease -> total_liability = $lastFlowPresentWithOpening -> liability_opening_balance;
                    $lease -> depreciation_closing = LeaseFlowService ::findDepreciationClosing($lastFlowPresentWithOpening, $accountingDate, $lastFlowPresentWithOpening -> depreciation_opening_balance, $lastFlowPresentWithOpening -> start_date);
                    $lastFlowPlusYear = LeaseFlowService :: leaseFlowPlusYear($lease, $accountingDatePlusYear, $lastFlowPresentWithOpening -> lease_extension_id);
                    if(!$lastFlowPlusYear) {
                        $lease -> long_term_liability_amount_in_currency = 0;
                    } else {
                        $lease -> long_term_liability_amount_in_currency = $lastFlowPlusYear -> liability_closing_balance;
                    }
                    $lease -> monthly_depreciation = LeaseFlowService ::monthDepreciationWithMonth($lastFlowPresentWithOpening);
                } elseif(LeaseFlowService ::checkIfLastLeaseFlow($lastFlowPresent)) {
                    $lease -> depreciation_closing = LeaseFlowService ::findDepreciationClosing($lastFlowPresent, $accountingDate,
                        $lastFlowPresent -> depreciation_closing_balance, $lastFlowPresent -> end_date);
                    $lease -> monthly_depreciation = LeaseFlowService ::monthDepreciationWithMonth($lastFlowPresent);
                } else {
                    $lease -> total_liability = $lastFlowPresent -> liability_closing_balance;
                    $lastFlowPlusYear = LeaseFlowService :: leaseFlowPlusYear($lease, $accountingDatePlusYear, $lastFlowPresent -> lease_extension_id);
                    $lease -> long_term_liability_amount_in_currency = $lastFlowPlusYear -> liability_closing_balance;
                    $lease -> depreciation_closing = LeaseFlowService ::findDepreciationClosing($lastFlowPresent, $accountingDate,
                        $lastFlowPresent -> depreciation_closing_balance, $lastFlowPresent -> end_date);
                    $lease -> monthly_depreciation = LeaseFlowService ::monthDepreciationWithMonth($lastFlowPresent);
                }
                return myFormat($lease -> total_liability);
            })*/
            -> editColumn('total_liability_amount_in_base_currency', function ($lease) use ($accountingDate) {
                $lease -> total_liability_amount_in_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> total_liability, $accountingDate);
                return myFormat($lease -> total_liability_amount_in_base_currency);
            })
            -> editColumn('long_term_liability_amount_in_currency', function ($lease) use ($accountingDate, $accountingDatePlusYear) {
                return myFormat($lease -> long_term_liability_amount_in_currency);
            })
            -> editColumn('long_term_liability_amount_in_base_currency', function ($lease) use ($accountingDate) {
                $lease -> long_term_liability_amount_in_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> long_term_liability_amount_in_currency, $accountingDate);
                return myFormat($lease -> long_term_liability_amount_in_base_currency);
            })
            -> editColumn('short_term_liability_amount_in_currency', function ($lease) {
                return mYFormat($lease -> total_liability - $lease -> long_term_liability_amount_in_currency);
            })
            -> editColumn('short_term_liability_amount_in_base_currency', function ($lease) use ($accountingDate) {
                return myFormat($lease -> total_liability_amount_in_base_currency - $lease -> long_term_liability_amount_in_currency);
            })
            -> editColumn('accrued_interest_in_currency', function ($lease) use ($accountingDate) {
                $lease -> accrued_interest = LeaseService ::getAccruedInterestPerLease($lease, $accountingDate);
                return myFormat($lease -> accrued_interest);
            })
            -> editColumn('accrued_interest_in_in_base_currency', function ($lease) use ($accountingDate) {
                $lease -> accrued_interest_in_in_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> accrued_interest, $accountingDate);
                return myFormat($lease -> accrued_interest_in_in_base_currency);
            })
            -> editColumn('right_of_use_asset_amount_in_currency', function ($lease) use ($accountingDate, $accountingDatePlusYear) {
                $lease -> depreciation_closing_base_currency = $this -> calculateMonthlyDepreciation($lease, $lease -> depreciation_closing, $accountingDate);
                return myFormat($lease -> depreciation_closing_base_currency);
            })
            -> editColumn('right_of_use_asset_amount_in_base_currency', function ($lease) use ($accountingDate) {
                return myFormat($this -> changeToSelectedCurrency($lease, $lease -> depreciation_closing_base_currency, $accountingDate));
            })
            -> editColumn('depreciation_to_right_of_use_asset_amount_in_currency', function ($lease) use ($accountingDate) {
                $lease -> monthly_depreciation = $this -> calculateMonthlyDepreciation($lease, $lease -> monthly_depreciation, $accountingDate);
                return myFormat($lease -> monthly_depreciation);
            })
            -> editColumn('depreciation_to_right_of_use_asset_amount_in_base_currency', function ($lease) use ($accountingDate) {
                return myFormat($this -> changeToSelectedCurrency($lease, $lease -> monthly_depreciation, $accountingDate));
            })
            -> editColumn('currency_valuation_to_liability', function ($lease) use ($accountingDate) {
                $lease -> total_liability_variation = $this -> calculateMonthlyLiability($lease, $lease -> total_liability, $accountingDate);
                return myFormat($lease -> total_liability_variation);
            })
            -> editColumn('id', function ($lease) {
                return '<a href="/leases/' . $lease -> id . '/edit" target="_blank"> ' . $lease -> id . '</a>';
            })
            -> rawColumns(['currency_id', 'id']);
    }

    public function query()
    {
        $accountingDate = Carbon ::parse(request() -> end_date) -> endOfMonth() -> toDateString();
        return $leases = Lease ::has('leaseFlow') -> with('entity', 'currency', 'leaseType', 'portfolio', 'costCenter') -> where('effective_date', '<', $accountingDate) -> where('maturity_date', '>=', $accountingDate) -> reportable() -> get();
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
                'end_date' => request('end_date')
            ])
            -> ajax()
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
                    $(api.column(17).footer()).html(api.column([17]).data().sum());
                    $(api.column(18).footer()).html(api.column([18]).data().sum());
                    $(api.column(19).footer()).html(api.column([19]).data().sum());
                     }')
            -> parameters([
                'dom' => 'Bfrtip',
                'buttons' => [['extend' => 'excelHtml5', 'footer' => true], ['extend' => 'csvHtml5', 'footer' => true],
                    'print', ['extend' => 'copyHtml5', 'footer' => true], ['extend' => 'pdfHtml5', 'footer' => true, 'orientation' => 'landscape', 'pageSize' => 'A2'], 'pageLength'],
                'pageLength' => 25,
                "aLengthMenu" => [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, "All"]],
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
            'id' => ['data' => 'id', 'name' => 'id', 'title' => 'Lease ID'],
            'entity_id' => ['data' => 'entity.short_name', 'name' => 'entity.short_name', 'title' => 'Entity'],
            'report_date',
            'lease_type_id' => ['data' => 'lease_type.type', 'name' => 'leaseType.type', 'title' => 'Lease Type'],
            'portfolio_id' => ['data' => 'portfolio.name', 'name' => 'portfolio.name', 'title' => 'Portfolio'],
            'cost_center_id' => ['name' => 'costCenter.short_name', 'title' => 'Cost Center'],
            'currency_id' => ['name' => 'currency.iso_4217_code', 'title' => 'Currency'],
            'short_term_liability_amount_in_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Short-term Liability amount in currency'],
            'short_term_liability_amount_in_base_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Short-term Liability amount in base currency'],
            'long_term_liability_amount_in_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Long-term Liability amount in currency'],
            'long_term_liability_amount_in_base_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Long-term Liability amount in base currency'],
            'total_liability_amount_in_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Total Liability in currency'],
            'total_liability_amount_in_base_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Total Liability in base currency'],
            'currency_valuation_to_liability' => ['name' => 'currency.iso_4217_code', 'title' => 'Currency valuation to liability'],
            'accrued_interest_in_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Accrued interest in currency'],
            'accrued_interest_in_in_base_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Accrued interest in base currency'],
            'right_of_use_asset_amount_in_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Right-of-Use Asset amount in base currency'],
            'right_of_use_asset_amount_in_base_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Right-of-Use Asset amount in selected currency'],
            'depreciation_to_right_of_use_asset_amount_in_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Depreciation to Right-of-Use Asset in base currency'],
            'depreciation_to_right_of_use_asset_amount_in_base_currency' => ['name' => 'currency.iso_4217_code', 'title' => 'Depreciation to Right-of-Use Asset in selected currency'],
        ];
    }

    /**
     * Get filename for export.
     * @return string
     */
    protected
    function filename()
    {
        return 'Lease_Month_End_Report_' . date('YmdHis');
    }

    public function checkBaseCurrencyAndConvert($lease, $amount, $date = null)
    {
        $accountingDate = $date ?: $lease -> effective_date;
        $baseCurrency = $this -> getCurrencyLease($lease -> entity_id);
        if($baseCurrency -> id != $lease -> currency_id)
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $accountingDate, $baseCurrency, $lease -> currency);

        return $amount;
    }

    public function changeToSelectedCurrency($lease, $amount, $accountingDate)
    {
        $crossCurrency = $this -> getCurrency($lease -> entity_id);
        if(request() -> get('currency_id') != null && $crossCurrency -> id != request() -> get('currency_id')) {
            $baseCurrency = Currency ::findOrFail(request() -> get('currency_id'));
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $accountingDate, $baseCurrency, $crossCurrency);

        }

        return $amount;
    }

    public function getCurrencyLease($entityId = null)
    {
        if(request() -> get('currency_id')) {
            return Currency ::findOrFail(request() -> get('currency_id'));
        }

        return CurrencyService ::getCompanyBaseCurrency($entityId);
    }

    public function getCurrency($entityId = null)
    {
        return CurrencyService ::getCompanyBaseCurrency($entityId);
    }

}