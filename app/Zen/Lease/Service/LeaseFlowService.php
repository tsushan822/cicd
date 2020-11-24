<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 09/05/2018
 * Time: 10.07
 */

namespace App\Zen\Lease\Service;


use App\Exceptions\CustomException;
use App\Zen\Lease\Calculate\IFRS\LeaseDiscount;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Setting\Calculate\DateTime\BusinessDateConvention;
use App\Zen\Setting\Calculate\DateTime\Traits\PaymentDayCalculation;
use Carbon\Carbon;

class LeaseFlowService
{
    use PaymentDayCalculation;

    public static function variationSum($lease, $extensionId = false)
    {
        $variationSum = LeaseFlow ::where('lease_id', $lease -> id) -> sum('variations');
        if($extensionId)
            $variationSum = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $extensionId) -> sum('variations');
        return $variationSum;

    }

    public static function leaseLiabilityOpeningBalance($lease, $extensionId = false)
    {
        $openingBalance = self ::variationSum($lease, $extensionId);
        $leaseLiabilityOpeningBalance = $openingBalance;
        $variableSum = self ::calculateLeaseEndPaymentsDiscount($lease, $extensionId);
        $leaseLiabilityOpeningBalance = $leaseLiabilityOpeningBalance + $variableSum;
        return $leaseLiabilityOpeningBalance;
    }

    public static function calculateLeaseEndPaymentsDiscount($lease, $extensionId = false)
    {
        $variableSum = 0;
        $leaseFlowsNoDepreciation = self ::leaseFlowsNoDepreciation($lease, $extensionId);
        if($extensionId) {
            $leaseExtension = LeaseExtension ::findOrFail($extensionId);
            $variables = [$leaseExtension -> extension_exercise_price, $leaseExtension -> extension_residual_value_guarantee,
                $leaseExtension -> extension_penalties_for_terminating];
            $rate = $leaseExtension -> lease_extension_rate;
        } else {
            $variables = [$lease -> exercise_price, $lease -> residual_value_guarantee, $lease -> penalties_for_terminating];
            $rate = $lease -> lease_rate;
        }
        foreach($variables as $variable) {
            $variableSum = $variableSum + (new LeaseDiscount($lease)) -> calculateVariables($rate, $variable, $lease -> lease_flow_per_year, count($leaseFlowsNoDepreciation));
        }
        return $variableSum;
    }

    public static function leaseFlows($lease, $extensionId = null)
    {
        $leaseFlows = LeaseFlow ::where(['lease_id' => $lease -> id]) -> get();
        if($extensionId)
            $leaseFlows = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $extensionId) -> get();

        return $leaseFlows;
    }

    public static function leaseFlowsAll($lease, $extensionId = null)
    {
        $leaseFlows = LeaseFlow ::where(['lease_id' => $lease -> id]) -> get();
        if($extensionId)
            $leaseFlows = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $extensionId) -> get();

        return $leaseFlows;
    }

    public static function leaseFlowsNoDepreciation($lease, $extensionId = false)
    {
        $leaseFlows = LeaseFlow ::where(['lease_id' => $lease -> id]) -> get();
        if($extensionId)
            $leaseFlows = LeaseFlow ::where(['lease_id' => $lease -> id, 'lease_extension_id' => $extensionId]) -> get();

        return $leaseFlows;
    }

    public static function leaseFlowsNoDepreciationWithTrashed($lease, $extensionId)
    {
        $leaseFlows = LeaseFlow ::where(['lease_id' => $lease -> id, 'lease_extension_id' => $extensionId])
            -> withTrashed() -> get();

        return $leaseFlows;
    }

    public static function lastLeaseFlowNoDepreciation($leaseId, $extensionId = false)
    {
        $leaseFlow = LeaseFlow ::where(['lease_id' => $leaseId]) -> orderBy('end_date', 'desc') -> limit(1) -> first();
        if($extensionId)
            $leaseFlow = LeaseFlow ::where(['lease_id' => $leaseId, 'lease_extension_id' => $extensionId]) -> orderBy('end_date', 'desc') -> limit(1) -> first();
        return $leaseFlow;
    }

    public static function lastLeaseFlowNoDepreciationWithSoftDelete($lease, $extensionId = false)
    {
        $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id]) -> withTrashed() -> orderBy('end_date', 'desc') -> limit(1) -> first();
        if($extensionId)
            $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id, 'lease_extension_id' => $extensionId]) -> withTrashed() -> orderBy('end_date', 'desc') -> limit(1) -> first();
        return $leaseFlow;
    }

    public static function firstLeaseFlowNoDepreciation($lease, $extensionId = false)
    {
        $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id]) -> orderBy('end_date', 'asc') -> limit(1) -> first();
        if($extensionId)
            $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id, 'lease_extension_id' => $extensionId]) -> orderBy('end_date', 'asc') -> first();
        return $leaseFlow;
    }

    public static function followingLeaseFlowNoDepreciationAfterDate($lease, $calculationDate = null, $extensionId = false)
    {
        if(!$calculationDate)
            $calculationDate = Carbon ::today() -> toDateString();

        $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id]) -> where('end_date', '=>', $calculationDate)
            -> orderBy('end_date', 'asc') -> limit(1) -> first();
        if($extensionId)
            $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id, 'lease_extension_id' => $extensionId])
                -> where('end_date', '=>', $calculationDate) -> orderBy('end_date', 'asc') -> limit(1) -> first();
        return $leaseFlow;
    }

    public static function previousLeaseFlowNoDepreciationBeforeDate($lease, $calculationDate = null, $extensionId = false)
    {
        if(!$calculationDate)
            $calculationDate = Carbon ::today() -> toDateString();

        $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id]) -> where('end_date', '<=', $calculationDate)
            -> orderBy('end_date', 'desc') -> limit(1) -> first();
        if($extensionId)
            $leaseFlow = LeaseFlow ::where(['lease_id' => $lease -> id, 'lease_extension_id' => $extensionId])
                -> where('end_date', '<=', $calculationDate) -> orderBy('end_date', 'desc') -> limit(1) -> first();
        return $leaseFlow;
    }

    public static function deleteLeaseFlow($leaseId, $endDate)
    {
        return LeaseFlow ::where('lease_id', $leaseId) -> where('end_date', '>', $endDate) -> delete();
    }

    public static function allLeaseFlowsBeforeDate($lease, $date)
    {
        $leaseFlows = LeaseFlow ::where('lease_id', $lease -> id) -> where('end_date', '<', $date) -> get();
        return $leaseFlows;
    }

    public static function deleteAllEmptyDepreciation($lease)
    {
        $attr = [
            'depreciation_opening_balance' => 0,
            'depreciation' => 0,
            'depreciation_closing_balance' => 0,
            'liability_opening_balance' => 0,
            'interest_cost' => 0,
            'liability_closing_balance' => 0,
            'lease_id' => $lease -> id,
        ];
        $deleteAllEmptyDepreciation = LeaseFlow ::where($attr) -> onlyDepreciation() -> forceDelete();;
        return $deleteAllEmptyDepreciation;
    }

    public static function monthDepreciation($leaseFlow)
    {
        $paymentsPerYear = $leaseFlow -> lease -> lease_flow_per_year;
        $monthDepreciation = $leaseFlow -> depreciation / 12 * $paymentsPerYear;
        return $monthDepreciation;
    }

    public static function monthDepreciationWithMonth($leaseFlow)
    {
        $lengthOfLeaseFlow = self ::lengthOfLeaseFlow($leaseFlow);
        return $leaseFlow -> depreciation / $lengthOfLeaseFlow;
    }

    public static function monthInterestWithMonth($leaseFlow)
    {
        $lengthOfLeaseFlow = self ::lengthOfLeaseFlow($leaseFlow);
        return $leaseFlow -> interest_cost / $lengthOfLeaseFlow;
    }

    public static function leaseFlowAtGivenTime($lease, $date)
    {
        $leaseFlow = LeaseFlow ::where('lease_id', $lease -> id) -> where('start_date', '<', $date) -> where('end_date', '>=', $date) -> first();
        return $leaseFlow;
    }

    public static function leaseFlowsWithDelete($lease, $extensionId)
    {
        $leaseFlows = LeaseFlow ::where(['lease_id' => $lease -> id]) -> withTrashed() -> get();
        if($extensionId)
            $leaseFlows = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $extensionId) -> withTrashed() -> get();

        return $leaseFlows;
    }

    public static function leaseFlowWithDepreciation($accountingDate)
    {
        $leaseIdArray = Lease ::reportable() -> where('effective_date', '<', $accountingDate) -> pluck('id') -> toArray();
        $leaseFlows = LeaseFlow :: where('end_date', '>=', $accountingDate)
            -> whereIn('lease_id', $leaseIdArray) -> orderBy('end_date', 'asc') -> limit(1) -> get();

        return $leaseFlows;
    }

    public static function allLeaseFlowAtTime($accountingDate)
    {
        $leaseIdArray = Lease ::reportable() -> where('effective_date', '<', $accountingDate) -> pluck('id') -> toArray();
        $leaseFlows = LeaseFlow ::where('end_date', '>=', $accountingDate)
            -> whereIn('lease_id', $leaseIdArray) -> orderBy('end_date', 'asc') -> get();

        return $leaseFlows;
    }

    public static function leaseFlowPresent($lease, $accountingDate)
    {
        $lastFlowPresent = LeaseFlow ::where(['lease_id' => $lease -> id]) -> where('end_date', '=', $accountingDate)
            -> orderBy('end_date', 'desc') -> limit(1) -> first();
        /*if(!$lastFlowPresent)
        {
            $lastFlowPresent = LeaseFlow ::where(['lease_id' => $lease -> id]) -> where('end_date', '=', $accountingDate)
                -> orderBy('end_date', 'desc') -> limit(1) -> toSql();

        }*/

        return $lastFlowPresent;

    }

    public static function leaseFlowPresentWithOpening($leaseId, $accountingDate)
    {
        $lastFlowPresent = LeaseFlow ::where(['lease_id' => $leaseId]) -> where('start_date', '<=', $accountingDate)
            -> orderBy('start_date', 'desc') -> limit(1) -> first();
        if($lastFlowPresent instanceof LeaseFlow)
            return $lastFlowPresent;

        throw new CustomException('There is problem with lease id ' . $leaseId);

    }

    public static function leaseFlowPlusYear($lease, $accountingDate, $leaseExtensionId)
    {
        $lastFlowPresent = LeaseFlow ::where(['lease_id' => $lease -> id,
            'lease_extension_id' => $leaseExtensionId]) -> where('end_date', '<=', $accountingDate)
            -> orderBy('end_date', 'desc') -> withTrashed() -> limit(1) -> first();
        return $lastFlowPresent;
    }

    public static function leaseFlowPlusYearStartDate($lease, $accountingDate, $leaseExtensionId)
    {
        $lastFlowPresent = LeaseFlow ::where(['lease_id' => $lease -> id,
            'lease_extension_id' => $leaseExtensionId]) -> where('start_date', '<=', $accountingDate)
            -> orderBy('end_date', 'desc') -> withTrashed() -> limit(1) -> first();
        return $lastFlowPresent;
    }

    /**
     * @param $leaseFlow
     * @param $calculationDate
     * @param $amount
     * @param $amountDate
     * @return float|int
     * Find depreciation closing balance based on date and amount provided
     */
    public static function findDepreciationClosingFromExisting($leaseFlow, $calculationDate, $amount, $amountDate)
    {
        $monthDepreciation = self ::monthDepreciation($leaseFlow);
        $diffInDays = Carbon ::parse($calculationDate) -> diffInDays($amountDate);
        $diffInMonths = rnd($diffInDays / 30, 0);
        $totalAdjustment = $diffInMonths * $monthDepreciation;
        return $amount + $totalAdjustment;

    }

    /**
     * @param $leaseFlow
     * @param $calculationDate
     * @param $amount
     * @param $amountDate
     * @return float|int
     * Find depreciation closing balance based on date and amount provided
     */
    public static function findDepreciationClosing($leaseFlow, $calculationDate, $amount, $amountDate)
    {
        $monthDepreciation = self ::monthDepreciation($leaseFlow);
        $diffInDays = Carbon ::parse($calculationDate) -> diffInDays($amountDate);
        $diffInMonths = rnd($diffInDays / 30, 0);
        $totalAdjustment = $diffInMonths * $monthDepreciation;

        return $amount - $totalAdjustment;

    }

    public static function checkIfLastLeaseFlow($leaseFlow)
    {
        $lastFlow = self ::lastLeaseFlowNoDepreciation($leaseFlow -> lease_id);
        if($lastFlow -> id == $leaseFlow -> id)
            return true;

        return false;
    }

    public static function updatePaymentDay($paymentDate, Lease $lease)
    {
        if(self ::checkAdvanceAndNoTwelveFlows($lease)) {
            $paymentDate = self :: paymentDayCalculationWithMonthAdjustment($paymentDate, $lease -> payment_day, 1);
        } else {
            $paymentDate = self :: paymentDayCalculationWithMonthAdjustment($paymentDate, $lease -> payment_day);
        }

        $businessDayConvention = $lease -> leaseType -> businessDayConvention;
        $paymentDate = (new BusinessDateConvention()) -> convertDateWithBusinessDayConvention($businessDayConvention, $paymentDate);
        return $paymentDate;
    }

    public static function checkAdvanceAndNoTwelveFlows($lease)
    {
        return $lease -> leaseType -> payment_type == "Advance" && $lease -> lease_flow_per_year != 12;
    }

    public
    static function depreciationAmount(LeaseFlow $leaseFlow, $depreciationAmount)
    {
        $diffInMonths = self ::lengthOfLeaseFlow($leaseFlow);
        return $depreciationAmount * $diffInMonths;
    }

    public
    static function lengthOfLeaseFlow(LeaseFlow $leaseFlow)
    {
        $diffInDays = Carbon ::parse($leaseFlow -> start_date) -> diffInDays($leaseFlow -> end_date);
        $diffInMonths = round($diffInDays / 30);
        return $diffInMonths;
    }

    public
    static function startEndDate(Lease $lease, $depreciationOpeningAmount)
    {
        //Check if there is any residual value
        $depreciationOpeningAmount = $depreciationOpeningAmount - $lease -> residual_value;

        $startDateLeaseFlow = LeaseFlow ::where('lease_id', $lease -> id) -> orderBy('start_date', 'asc') -> limit(1) -> first();
        $startDate = $startDateLeaseFlow -> start_date;

        $endDateLeaseFlow = LeaseFlow ::where('lease_id', $lease -> id) -> orderBy('end_date', 'desc') -> limit(1) -> first();
        $endDate = $endDateLeaseFlow -> end_date;

        $diffInDays = Carbon ::parse($startDate) -> diffInDays($endDate);
        $numberOfMonths = round($diffInDays / 30.4375); //Considering year has 365 days

        return $depreciationOpeningAmount / $numberOfMonths;

    }

    public
    static function startEndDateBesideExtension(Lease $lease, $depreciationOpeningAmount, LeaseExtension $leaseExtension)
    {
        //Check if there is any residual value
        $depreciationOpeningAmount = $depreciationOpeningAmount - $lease -> residual_value;

        $startDateLeaseFlow = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $leaseExtension -> id) -> orderBy('start_date', 'asc') -> limit(1) -> first();
        $startDate = $startDateLeaseFlow -> start_date;

        $endDateLeaseFlow = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $leaseExtension -> id) -> orderBy('end_date', 'desc') -> limit(1) -> first();
        $endDate = $endDateLeaseFlow -> end_date;

        $diffInDays = Carbon ::parse($startDate) -> diffInDays($endDate);
        $numberOfMonths = round($diffInDays / 30.4375); //Considering year has 365 days

        return $depreciationOpeningAmount / $numberOfMonths;

    }

    public
    static function updateDepreciationMonthMigrate(Lease $lease, $depreciationOpeningAmount, LeaseExtension $leaseExtension)
    {
        //Check if there is any residual value
        $depreciationOpeningAmount = $depreciationOpeningAmount - $lease -> residual_value;

        $startDateLeaseFlow = LeaseFlow ::where('lease_id', $lease -> id) -> where('lease_extension_id', $leaseExtension -> id) -> orderBy('start_date', 'asc') -> limit(1) -> first();
        $startDate = $startDateLeaseFlow -> start_date;

        $endDateLeaseFlow = LeaseFlow ::withTrashed() -> where('lease_id', $lease -> id) -> where('lease_extension_id', $leaseExtension -> id) -> orderBy('end_date', 'desc') -> limit(1) -> first();
        $endDate = $endDateLeaseFlow -> end_date;

        $diffInDays = Carbon ::parse($startDate) -> diffInDays($endDate);
        $numberOfMonths = round($diffInDays / 30.4375); //Considering year has 365 days

        return $depreciationOpeningAmount / $numberOfMonths;

    }

    public
    static function checkIfLastLeaseFlowWithSoftDelete($lastFlowPresent)
    {
        $leaseFlow = self ::lastLeaseFlowNoDepreciationWithSoftDelete($lastFlowPresent -> lease);
        return $leaseFlow -> id === $lastFlowPresent -> id;
    }

    public
    static function updateRepayment($leaseId)
    {
        $leaseFlows = LeaseFlow ::withTrashed() -> whereLeaseId($leaseId) -> get();
        foreach($leaseFlows as $leaseFlow) {
            $leaseFlow -> repayment = $leaseFlow -> fixed_payment - $leaseFlow -> interest_cost;
            $leaseFlow -> save();
        }

        $lastLeaseFlow = LeaseFlowService ::lastLeaseFlowNoDepreciation($leaseId);
        if($lastLeaseFlow instanceof LeaseFlow) {
            $lastLeaseFlow -> repayment = self ::calculateRepayment($lastLeaseFlow);
            $lastLeaseFlow -> save();
        }

    }

    public
    static function updateShortLiabilityWithLease($lease)
    {
        $leaseFlows = LeaseFlow ::with('lease') -> where('lease_id', $lease -> id) -> get();

        foreach($leaseFlows as $leaseFlow) {
            self ::updateShortLiability($leaseFlow);
        }
    }

    public
    static function updateShortLiability($leaseFlow)
    {
        $accountingDatePlusYear = Carbon ::parse($leaseFlow -> end_date) -> addYearNoOverflow() -> endOfMonth() -> toDateString();
        $shortTermLiability = LeaseFlow ::where('end_date', '>', $leaseFlow -> end_date) -> where('end_date', '<=', $accountingDatePlusYear)
            -> withTrashed() -> where('lease_extension_id', $leaseFlow -> lease_extension_id) -> where('lease_id', $leaseFlow -> lease_id) -> sum('repayment');
        $leaseFlow -> short_term_liability = $shortTermLiability;
        $leaseFlow -> save();
    }

    public
    static function calculateRepayment($leaseFlow)
    {
        if(!$leaseFlow -> lease -> ifrs_accounting)
            return 0;

        $ifLastFlow = LeaseFlowService ::checkIfLastLeaseFlow($leaseFlow);
        $repayment = $leaseFlow -> fixed_payment - $leaseFlow -> interest_cost;

        if($ifLastFlow) {
            $endPayments = $leaseFlow -> leaseExtension -> extension_exercise_price + $leaseFlow -> leaseExtension -> extension_residual_value_guarantee +
                $leaseFlow -> leaseExtension -> extension_penalties_for_terminating;
            $repayment = $repayment + $endPayments;
        }

        return $repayment;
    }

    public
    static function calculateAccruedInterest($leaseFlow, $accountingDate, $amount = 0)
    {
        if($leaseFlow -> lease -> lease_flow_per_year == 12) {
            if($leaseFlow -> payment_date > $leaseFlow -> end_date) {
                return $amount ?: $leaseFlow -> interest_cost;
            }
            return 0;
        } else {
            if($leaseFlow -> payment_date > $leaseFlow -> end_date) {
                return $leaseFlow -> interest_cost + self ::getAccruedValue($leaseFlow, $accountingDate);
            } else {
                return self ::getAccruedValue($leaseFlow, $accountingDate);
            }
        }
    }
}