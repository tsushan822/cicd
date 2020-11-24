<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/06/2018
 * Time: 13.48
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Report\Generate\GetCurrencyForLease;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotesMaturityTable extends GetCurrencyForLease
{

    public function generateReport()
    {
        $returnData = collect();
        $startDate = request() -> end_date ?: Carbon ::today() -> toDateString();
        $calculationStartDate = $startDate;

        // IMPORTANT !!! Filtering of the lease is done in lease model
        $leaseIdArray = Lease ::reportable() -> pluck('id') -> toArray();
        $endDate = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> max('end_date');
        $months = Carbon ::parse($startDate) -> diffInMonths($endDate);
        $arr = [3, 6, 9];
        $i = 0;
        while ($i < $months + 1) {
            $i += 12;
            $arr[] = $i;
        }
        $id = 0;
        $currencies = Lease ::distinct() -> pluck('currency_id') -> toArray();

        $previousDay = Carbon ::parse($startDate) -> subDay() -> toDateString();
        foreach($arr as $item) {
            $endDate = Carbon ::parse($startDate) -> addMonthsNoOverflow($item) -> toDateString();
            $fixedAssetTotal = 0;
            $interestCostTotal = 0;
            $totalCostTotal = 0;
            $totalCostTotalBaseCur = 0;
            $fixedAssetAmountTotalBaseCurrency = 0;
            $interestCostTotalBaseCur = 0;
            $repaymentOfLeaseTotal = 0;
            $repaymentOfLeaseBaseCurrency = 0;

            foreach($currencies as $currency) {
                list($fixedAsset, $fixedAssetNonIfrs, $fixedAssetBaseCurrency) = $this -> fixedAssetSum($leaseIdArray, $calculationStartDate, $endDate, $currency, $previousDay);

                list($interestCost, $interestCostBaseCur) = $this -> interestCostSum($leaseIdArray, $calculationStartDate, $endDate, $currency, $previousDay);

                list($totalCost, $totalCostBaseCur) = $this -> totalCostSum($leaseIdArray, $calculationStartDate, $endDate, $currency, $previousDay);

                $repayment = $this -> repaymentSum($leaseIdArray, $calculationStartDate, $endDate, $currency);

                $repayment = $repayment + $fixedAssetNonIfrs - $interestCost;

                $repaymentOfLeaseBaseCur = $this -> checkBaseCurrencyAndConvertWithoutLease($repayment, $previousDay, $currency);

                $fixedAssetTotal = $fixedAssetTotal + $fixedAsset;
                $fixedAssetAmountTotalBaseCurrency = $fixedAssetAmountTotalBaseCurrency + $fixedAssetBaseCurrency;

                $interestCostTotal = $interestCostTotal + $interestCost;
                $interestCostTotalBaseCur = $interestCostTotalBaseCur + $interestCostBaseCur;

                $totalCostTotal = $totalCostTotal + $totalCost;
                $totalCostTotalBaseCur = $totalCostTotalBaseCur + $totalCostBaseCur;

                $repaymentOfLeaseTotal = $repaymentOfLeaseTotal + $repayment;
                $repaymentOfLeaseBaseCurrency = $repaymentOfLeaseBaseCurrency + $repaymentOfLeaseBaseCur;

            }
            $calculationStartDate = $endDate;
            switch($item / 12){
                case 0.25:
                    $duration = '0 - 3 Months';
                    break;
                case 0.5:
                    $duration = '4 - 6 Months';
                    break;
                case 0.75:
                    $duration = '7 - 9 Months';
                    break;
                case 1:
                    $duration = '10 - 12 Months';
                    break;
                default :
                    $duration = $item / 12 . ' Year(s)';
                    break;

            }


            $returnArray = [
                'id' => ++$id,
                'duration' => $duration,
                'total_amount' => $totalCostTotal,
                'total_amount_base_currency' => $totalCostTotalBaseCur,
                'fixed_amount' => $fixedAssetTotal,
                'fixed_amount_base_currency' => $fixedAssetAmountTotalBaseCurrency,
                'repayment_of_loan' => $repaymentOfLeaseTotal,
                'repayment_of_loan_base_currency' => $repaymentOfLeaseBaseCurrency,
                'interest_cost' => $interestCostTotal,
                'interest_cost_base_currency' => $interestCostTotalBaseCur,
                'base_currency' => ($this -> getBaseCurrency()) -> iso_4217_code,
            ];
            $returnData -> push((object)$returnArray);

        }
        return array($returnData, $startDate);
    }

    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @param string $previousDay
     * @return array
     */
    public function fixedAssetSum($leaseIdArray, string $calculationStartDate, string $endDate, $currency, string $previousDay): array
    {
        if(app('costCenterSplitAdmin') && request() -> input('cost_center_id')) {
            list($fixedAsset, $fixedAssetNonIfrs) = $this -> fixedAssetSumCostCenter($leaseIdArray, $calculationStartDate, $endDate, $currency);
        } else {
            list($fixedAsset, $fixedAssetNonIfrs) = $this -> fixedAssetSumCalculate($leaseIdArray, $calculationStartDate, $endDate, $currency);
        }


        $fixedAssetBaseCurrency = $this -> checkBaseCurrencyAndConvertWithoutLease($fixedAsset, $previousDay, $currency);
        return array($fixedAsset, $fixedAssetNonIfrs, $fixedAssetBaseCurrency);
    }

    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @param string $previousDay
     * @return array
     */
    public function interestCostSum($leaseIdArray, string $calculationStartDate, string $endDate, $currency, string $previousDay): array
    {
        if(app('costCenterSplitAdmin') && request() -> input('cost_center_id')) {
            $interestCost = $this -> interestCostSumCostCenter($leaseIdArray, $calculationStartDate, $endDate, $currency);
        } else {
            $interestCost = $this -> interestCostSumCalculate($leaseIdArray, $calculationStartDate, $endDate, $currency);
        }

        $interestCostBaseCurrency = $this -> checkBaseCurrencyAndConvertWithoutLease($interestCost, $previousDay, $currency);
        return array($interestCost, $interestCostBaseCurrency);
    }


    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @return mixed
     */
    public function interestCostSumCalculate($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        $interestCost = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency);
            }) -> sum('interest_cost');

        return $interestCost;
    }

    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @return mixed
     */
    public function interestCostSumCostCenter($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        $interestCostTotal = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('cost_center_split', '<>', 1);
            }) -> sum('interest_cost');

        $leaseFlows = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('cost_center_split', 1);
            }) -> get();

        foreach($leaseFlows as $leaseFlow) {
            $costCenterLease = $leaseFlow -> lease -> costCenters() -> where('cost_center_id', request() -> input('cost_center_id')) -> first();
            $interestCostTotal = $leaseFlow -> fixed_payment * $costCenterLease -> pivot_percentage;
        }
        return $interestCostTotal;
    }

    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @param string $previousDay
     * @return array
     */
    public function totalCostSum($leaseIdArray, string $calculationStartDate, string $endDate, $currency, string $previousDay): array
    {
        if(app('costCenterSplitAdmin') && request() -> input('cost_center_id')) {
            $interestCost = $this -> totalCostSumCostCenter($leaseIdArray, $calculationStartDate, $endDate, $currency);
        } else {
            $interestCost = $this -> totalCostSumCalculate($leaseIdArray, $calculationStartDate, $endDate, $currency);
        }

        $interestCostBaseCurrency = $this -> checkBaseCurrencyAndConvertWithoutLease($interestCost, $previousDay, $currency);
        return array($interestCost, $interestCostBaseCurrency);
    }


    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @return mixed
     */
    public function totalCostSumCalculate($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        $totalCost = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency);
            }) -> sum('total_payment');

        return $totalCost;
    }

    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @return mixed
     */
    public function totalCostSumCostCenter($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        $totalCostTotal = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('cost_center_split', '<>', 1);
            }) -> sum('total_payment');

        $leaseFlows = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('cost_center_split', 1);
            }) -> get();

        foreach($leaseFlows as $leaseFlow) {
            $costCenterLease = $leaseFlow -> lease -> costCenters() -> where('cost_center_id', request() -> input('cost_center_id')) -> first();
            $totalCostTotal = $leaseFlow -> total_payment * $costCenterLease -> pivot_percentage;
        }
        return $totalCostTotal;
    }

    public function repaymentSum($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        if(app('costCenterSplitAdmin') && request() -> input('cost_center_id')) {
            $repayment = $this -> repaymentSumCostCenter($leaseIdArray, $calculationStartDate, $endDate, $currency);
        } else {
            $repayment = $this -> repaymentSumCalculate($leaseIdArray, $calculationStartDate, $endDate, $currency);
        }
        return $repayment;
    }

    /**
     * @param $leaseIdArray
     * @param string $calculationStartDate
     * @param string $endDate
     * @param $currency
     * @return mixed
     */
    public function repaymentSumCalculate($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        $repayment = Lease :: whereIn('id', $leaseIdArray) -> where('maturity_date', '>=', $calculationStartDate)
            -> where('maturity_date', '<', $endDate) -> where('currency_id', '=', $currency)
            -> sum(DB ::raw('exercise_price+residual_value_guarantee+penalties_for_terminating'));
        return $repayment;
    }

    public function repaymentSumCostCenter($leaseIdArray, string $calculationStartDate, string $endDate, $currency)
    {
        $repaymentTotal = Lease :: whereIn('id', $leaseIdArray) -> where('maturity_date', '>=', $calculationStartDate)
            -> where('maturity_date', '<', $endDate) -> where('currency_id', '=', $currency) -> where('cost_center_split', '<>', 1)
            -> sum(DB ::raw('exercise_price+residual_value_guarantee+penalties_for_terminating'));

        $leases = Lease :: whereIn('id', $leaseIdArray) -> where('maturity_date', '>=', $calculationStartDate)
            -> where('maturity_date', '<', $endDate)
            -> where('currency_id', '=', $currency) -> where('cost_center_split', 1) -> get();

        foreach($leases as $lease) {
            $costCenterLease = $lease -> costCenters() -> where('cost_center_id', request() -> input('cost_center_id')) -> first();
            $repaymentTotal = $repaymentTotal + ($lease -> exercise_price + $lease -> residual_value_guarantee + $lease -> penalties_for_terminating) * $costCenterLease -> pivot_percentage;
        }

        return $repaymentTotal;
    }

    public function fixedAssetSumCostCenter($leaseIdArray, string $calculationStartDate, string $endDate, $currency): array
    {
        $fixedAssetTotal = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('cost_center_split', '<>', 1);
            }) -> sum('fixed_payment');

        $fixedAssetNonIfrs = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('ifrs_accounting', 1) -> where('cost_center_split', '<>', 1);
            }) -> sum('fixed_payment');


        $leaseFlows = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('cost_center_split', 1);
            }) -> get();

        foreach($leaseFlows as $leaseFlow) {

            $costCenterLease = $leaseFlow -> lease -> costCenters() -> where('cost_center_id', request() -> input('cost_center_id')) -> first();
            $fixedAsset = $leaseFlow -> fixed_payment * $costCenterLease -> pivot_percentage;

            if($leaseFlow -> lease -> ifrs_accounting) {
                $fixedAssetNonIfrs = $fixedAssetNonIfrs + $fixedAsset;
            }

            $fixedAssetTotal = $fixedAsset + $fixedAssetTotal;
        }
        return array($fixedAssetTotal, $fixedAssetNonIfrs);
    }

    public function fixedAssetSumCalculate($leaseIdArray, string $calculationStartDate, string $endDate, $currency): array
    {
        $fixedAsset = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency);
            }) -> sum('fixed_payment');

        $fixedAssetNonIfrs = LeaseFlow :: whereIn('lease_id', $leaseIdArray) -> where('payment_date', '>=', $calculationStartDate)
            -> where('payment_date', '<', $endDate) -> whereHas('lease', function ($q) use ($currency) {
                $q -> where('currency_id', '=', $currency) -> where('ifrs_accounting', 1);
            }) -> sum('fixed_payment');

        return array($fixedAsset, $fixedAssetNonIfrs);
    }
}