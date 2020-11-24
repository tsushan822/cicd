<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/05/2018
 * Time: 16.18
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseAccruedInterest;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Report\Generate\GetCurrencyForLease;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Service\Currency\CurrencyConversion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;

class LeaseMonthValue extends GetCurrencyForLease
{
    use Exportable;
    protected $baseCurrencyId = null;
    protected $accountingDate;
    private $conversionNeeded = false;
    private $accountingDatePlusYear;

    public function generateReport()
    {
        set_time_limit(1500);
        $accountingDate = request() -> end_date;
        $accountingDate = Carbon ::parse($accountingDate) -> endOfMonth() -> toDateString();
        return $this -> getAllReportData($accountingDate);
    }

    public function getAllReportData($accountingDate)
    {
        $this -> accountingDatePlusYear = Carbon ::parse($accountingDate) -> addMonthsNoOverflow(12) -> endOfMonth() -> toDateString();
        list($returnLeases, $leaseIdArray, $leaseFlowQuery) = $this -> setRequiredParameter($accountingDate);
        $leaseRemainingIds = array_diff($leaseIdArray, $leaseFlowQuery -> pluck('lease_id') -> toArray());
        foreach($leaseFlowQuery -> cursor() as $leaseFlow) {
            $lease = $leaseFlow -> lease;
            $this -> conversionNeeded = $this -> checkIfConversionNeeded($lease);
            $lease = $this -> setVariableSameAsPaymentDate($leaseFlow, $lease);
            $returnLeases -> push($lease);
        }

        //Calculate for other remaining leases
        if(count($leaseRemainingIds))
            $returnLeases = $this -> remainingNonMonthlyLease($leaseRemainingIds, $returnLeases);

        if(app('costCenterSplitAdmin')) {
            $returnLeases = $this -> addCostCenterSplit($returnLeases);
        }

        return $returnLeases;
    }

    public function getOnlyDepreciation($accountingDate)
    {
        list($returnLeases, $leaseIdArray, $leaseFlowQuery) = $this -> setRequiredParameter($accountingDate);

        $leaseRemainingIds = array_diff($leaseIdArray, $leaseFlowQuery -> pluck('lease_id') -> toArray());

        foreach($leaseFlowQuery -> cursor() as $leaseFlow) {
            $lease = $leaseFlow -> lease;

            $this -> conversionNeeded = $this -> checkIfConversionNeeded($lease);

            $lease = $this -> getDepreciationSelectedCurrency($leaseFlow, $lease);

            $returnLeases -> push($lease);
        }

        //Calculate for other remaining leases
        if(count($leaseRemainingIds)) {

            foreach(Lease ::whereIn('id', $leaseRemainingIds) -> cursor() as $lease) {
                $this -> conversionNeeded = $this -> checkIfConversionNeeded($lease);

                $currentLeaseFlow = LeaseFlow ::where('end_date', '<>', $this -> accountingDate) -> where('start_date', '<', $this -> accountingDate) -> where('end_date', '>', $this -> accountingDate)
                    -> where('lease_id', $lease -> id) -> orderBy('end_date', 'desc') -> first();

                if($currentLeaseFlow instanceof LeaseFlow) {
                    $lease = $this -> getDepreciationSelectedCurrency($currentLeaseFlow, $lease);
                    $returnLeases -> push($lease);
                    continue;
                }

            }
        }

        if(app('costCenterSplitAdmin')) {
            $arrayToConvert = ['monthly_depreciation', 'monthly_depreciation_selected_currency'];
            $returnLeases = $this -> addCostCenterSplit($returnLeases, $arrayToConvert);
        }

        return $returnLeases;

    }

    /**
     * @param $accountingDate
     * @return $this
     */
    public function setAccountingDate($accountingDate)
    {
        $this -> accountingDate = $accountingDate;
        return $this;
    }

    public
    function accruedInterestSameDate($lease, $leaseFlow)
    {
        return (new LeaseAccruedInterest()) -> setLeaseFlow($leaseFlow) -> setLease($lease) -> setAmount($leaseFlow -> interest_cost) -> setAccountingDate($this -> accountingDate) -> calculateAccruedValue();
    }

    public
    function accruedInterestBeforeDate($leaseFlow, $lease)
    {
        // return $leaseFlow -> interest_cost * (Carbon ::parse($this -> accountingDate) -> diffInDays($leaseFlow -> start_date)) / (Carbon ::parse($leaseFlow -> start_date) -> diffInDays($leaseFlow -> end_date));
        return (new LeaseAccruedInterest()) -> setLeaseFlow($leaseFlow) -> setLease($lease) -> setAmount($leaseFlow -> interest_cost) -> setAccountingDate($this -> accountingDate) -> calculateAccruedValue();
    }

    public
    function setVariableSameAsPaymentDate($leaseFlow, $lease)
    {
        $lease -> accrued_interest = $this -> accruedInterestSameDate($lease, $leaseFlow);
        $lease -> total_liability = $this -> totalLiability($lease, $leaseFlow);
        $lease -> short_term_liability = $this -> shortTermLiability($lease, $leaseFlow);
        $lease -> long_term_liability = $lease -> total_liability - $lease -> short_term_liability;
        $lease -> monthly_depreciation = $this -> calculateMonthlyDepBaseCurrency($leaseFlow, $leaseFlow -> leaseExtension -> monthly_depreciation);
        $lease -> depreciation_closing_base_currency = $this -> calculateMonthlyDepBaseCurrency($leaseFlow, $leaseFlow -> depreciation_closing_balance);
        if($this -> conversionNeeded)
            $lease = $this -> withConversion($lease);
        else
            $lease = $this -> noConversion($lease);
        $lease -> total_liability_variation = $this -> calculateCurrencyValuation($leaseFlow, $lease);
        return $lease;
    }

    public function getDepreciationSelectedCurrency($leaseFlow, $lease)
    {
        $lease -> monthly_depreciation = $this -> calculateMonthlyDepBaseCurrency($leaseFlow, $leaseFlow -> leaseExtension -> monthly_depreciation);
        $lease -> monthly_depreciation_selected_currency = $this -> changeToSelectedCurrency($lease, $lease -> monthly_depreciation);
        return $lease;
    }

    public function eligibleLeaseMonthEnd($accountingDate)
    {
        return Lease ::with('leaseFlow') -> where('effective_date', '<', $accountingDate)
            -> where('maturity_date', '>=', $accountingDate);
    }

    public
    function setVariableAfterPaymentDate($lease, $currentLeaseFlow)
    {
        $shortLiability = $this -> shortTermLiability($lease, $currentLeaseFlow);
        $lease -> accrued_interest = $this -> accruedInterestBeforeDate($currentLeaseFlow, $lease);
        $lease -> total_liability = $this -> totalLiability($lease, $currentLeaseFlow);
        $lease -> short_term_liability = $shortLiability;
        $lease -> long_term_liability = $lease -> total_liability - $shortLiability;
        $monthDep = $currentLeaseFlow -> leaseExtension -> monthly_depreciation;
        $lease -> monthly_depreciation = $this -> calculateMonthlyDepBaseCurrency($currentLeaseFlow, $monthDep);
        $depreciationClosingBaseCurrency = $currentLeaseFlow -> depreciation_closing_balance + $monthDep * rnd((Carbon ::parse($this -> accountingDate) -> diffInDays($currentLeaseFlow -> end_date)) / 30, 0);
        $lease -> depreciation_closing_base_currency = $this -> calculateMonthlyDepBaseCurrency($currentLeaseFlow, $depreciationClosingBaseCurrency);
        if($this -> conversionNeeded)
            $lease = $this -> withConversion($lease);
        else
            $lease = $this -> noConversion($lease);
        $lease -> total_liability_variation = $this -> calculateCurrencyValuation($currentLeaseFlow, $lease);

        return $lease;

    }

    private function withConversion($lease)
    {
        $lease -> long_term_liability_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> long_term_liability, $this -> accountingDate);
        $lease -> total_liability_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> total_liability, $this -> accountingDate);
        $lease -> short_term_liability_base_currency = $lease -> total_liability_base_currency - $lease -> long_term_liability_base_currency;
        $lease -> accrued_interest_base_currency = $lease -> accrued_interest ? $this -> checkBaseCurrencyAndConvert($lease, $lease -> accrued_interest, $this -> accountingDate) : $lease -> accrued_interest;
        $lease -> total_liability_variation = 0;
        $lease -> monthly_depreciation_selected_currency = $this -> changeToSelectedCurrency($lease, $lease -> monthly_depreciation);
        $lease -> depreciation_closing_selected_currency = $this -> changeToSelectedCurrency($lease, $lease -> depreciation_closing_base_currency);
        return $lease;
    }

    private function noConversion($lease)
    {
        $lease -> long_term_liability_base_currency = $lease -> long_term_liability;
        $lease -> total_liability_base_currency = $lease -> total_liability;
        $lease -> short_term_liability_base_currency = $lease -> short_term_liability;
        $lease -> accrued_interest_base_currency = $lease -> accrued_interest;
        $lease -> total_liability_variation = 0;
        $lease -> monthly_depreciation_selected_currency = $this -> changeToSelectedCurrency($lease, $lease -> monthly_depreciation);
        $lease -> depreciation_closing_selected_currency = $this -> changeToSelectedCurrency($lease, $lease -> depreciation_closing_base_currency);
        return $lease;
    }


    /**
     * @param $leaseRemainingIds
     * @param $returnLeases
     * @return mixed
     */
    public function remainingNonMonthlyLease($leaseRemainingIds, $returnLeases)
    {
        foreach(Lease ::whereIn('id', $leaseRemainingIds) -> cursor() as $lease) {
            $this -> conversionNeeded = $this -> checkIfConversionNeeded($lease);

            $currentLeaseFlow = LeaseFlow ::where('end_date', '<>', $this -> accountingDate) -> where('start_date', '<', $this -> accountingDate) -> where('end_date', '>', $this -> accountingDate)
                -> where('lease_id', $lease -> id) -> orderBy('end_date', 'desc') -> first();

            if($currentLeaseFlow instanceof LeaseFlow) {
                $lease = $this -> setVariableAfterPaymentDate($lease, $currentLeaseFlow);
                $returnLeases -> push($lease);
                continue;
            }

        }
        return $returnLeases;
    }

    public function changeToSelectedCurrency($lease, $amount)
    {
        $crossCurrency = $this -> getCurrency($lease -> entity_id);
        if($this -> baseCurrencyId != false && $crossCurrency -> id != $this -> baseCurrencyId) {
            $baseCurrency = Currency ::findOrFail($this -> baseCurrencyId);
            return CurrencyConversion ::currencyAmountToBaseAmount($amount, $this -> accountingDate, $baseCurrency, $crossCurrency);
        }

        return $amount;
    }

    /**
     * @param $leaseFlow
     * @param $lease
     * @return float|int
     */
    public function calculateCurrencyValuation($leaseFlow, $lease)
    {
        return $lease -> total_liability != $lease -> total_liability_base_currency
        && $leaseFlow -> leaseExtension -> liability_conversion_rate
        && (!$this -> baseCurrencyId || $this -> baseCurrencyId == $lease -> entity -> currency_id)
            ? $lease -> total_liability / $leaseFlow -> leaseExtension -> liability_conversion_rate - $lease -> total_liability_base_currency : 0;
    }

    /**
     * @param $leaseFlow
     * @param $amount
     * @return float|int
     */
    public function calculateMonthlyDepBaseCurrency($leaseFlow, $amount)
    {
        return $leaseFlow -> leaseExtension -> depreciation_conversion_rate ? $amount / $leaseFlow -> leaseExtension -> depreciation_conversion_rate : $amount;
    }

    /**
     * @param $leaseFlow
     * @param $amount
     * @return float|int
     */
    public function calculateMonthlyDepSelectedCurrency($leaseFlow, $amount)
    {
        return $leaseFlow -> leaseExtension -> depreciation_conversion_rate ? $amount / $leaseFlow -> leaseExtension -> depreciation_conversion_rate : $amount;
    }

    /**
     * @param $accountingDate
     * @return array
     */
    public function setRequiredParameter($accountingDate): array
    {
        $this -> setAccountingDate($accountingDate);
        $returnLeases = collect();
        if(request() -> currency_id) {
            $this -> setBaseCurrencyId(request() -> currency_id);
        }
        $leaseIdArray = $this -> eligibleLeaseMonthEnd($this -> accountingDate) -> reportable() -> pluck('id') -> toArray();
        $leaseFlowQuery = LeaseFlow ::with('lease', 'lease.entity', 'lease.currency', 'lease.leaseType', 'lease.portfolio',
            'lease.costCenter', 'lease.leaseExtension') -> where('end_date', $this -> accountingDate) -> whereIn('lease_id', $leaseIdArray);
        return array($returnLeases, $leaseIdArray, $leaseFlowQuery);
    }

    /**
     * @param $lease
     * @return bool
     */
    public function checkIfConversionNeeded($lease): bool
    {
        return $this -> baseCurrencyId ? !($this -> baseCurrencyId == $lease -> currency_id) : !($lease -> entity -> currency_id == $lease -> currency_id);
    }

    /**
     * @param $returnLeases
     * @param array $arrayToConvert
     * @return array $returnLeases
     */
    public function addCostCenterSplit($returnLeases, $arrayToConvert = [])
    {
        $i = 0;
        $arrayToConvert = count($arrayToConvert) ? $arrayToConvert : ['short_term_liability', 'short_term_liability_base_currency', 'long_term_liability_base_currency', 'long_term_liability', 'total_liability_base_currency', 'total_liability', 'total_liability_variation', 'accrued_interest', 'accrued_interest_base_currency', 'depreciation_closing_base_currency', 'depreciation_closing_selected_currency', 'monthly_depreciation', 'monthly_depreciation_selected_currency'];
        foreach($returnLeases as $returnLease) {
            if($returnLease -> cost_center_split) {
                foreach($returnLease -> costCenters as $item) {

                    if(!empty(request() -> input('cost_center_id')) && !in_array($item -> id, request() -> input('cost_center_id')))
                        continue;

                    $newFlow = clone $returnLease;
                    foreach($arrayToConvert as $data) {
                        $newFlow -> $data = $returnLease -> $data * $item -> pivot -> percentage / 100;
                    }
                    $newFlow -> cost_center_name = $item -> short_name;
                    $returnLeases -> push($newFlow);
                }
                $returnLeases -> forget([$i]);
            }
            $i++;
        }

        return $returnLeases;
    }

    /**
     * @param $lease
     * @param $leaseFlow
     * @return mixed
     */
    private function shortTermLiability($lease, $leaseFlow)
    {
        $shortLiability = LeaseFlow ::with('leaseExtension') -> where('payment_date', '>=', Carbon ::parse($this -> accountingDate) -> addDay() -> toDateString()) -> where('payment_date', '<=', Carbon ::parse($this -> accountingDatePlusYear) -> toDateString())
            -> where('lease_id', $lease -> id) -> where('lease_extension_id', $leaseFlow -> lease_extension_id) -> withTrashed() -> sum('repayment');
        return $shortLiability;

    }


    /**
     * @param $lease
     * @param $leaseFlow
     * @return mixed
     */
    private function totalLiability($lease, $leaseFlow)
    {
        $totalLiability = LeaseFlow ::where('payment_date', '>=', Carbon ::parse($this -> accountingDate) -> addDay() -> toDateString()) -> withTrashed() -> where('lease_id', $lease -> id) -> where('lease_extension_id', $leaseFlow -> lease_extension_id) -> sum('repayment');

        return $totalLiability;
    }

}