<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/04/2018
 * Time: 15.10
 */

namespace App\Zen\Lease\Calculate\Generate;

use App\Scopes\LeaseAccountableScope;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Setting\Calculate\Generate\GenerateFlow;
use Carbon\Carbon;

class GenerateLeaseFlow extends GenerateFlow
{
    protected $lease;

    public static function generateLeaseFlow($request)
    {
        $leaseId = $request -> lease;
        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);

        $negotiatePriceIncreasePercent = $request -> negotiate_price_increase_percent;
        $negotiatePriceIncreaseAmount = $request -> negotiate_price_increase_amount;
        $dateOfFirstPriceIncrease = $request -> date_of_first_price_increase;

        $startDate = $request -> payment_date;
        $calcStartDate = $lease -> effective_date;
        $maturityDate = $request -> end_date;

        $fees = $request -> fees;
        $paymentDates = (new self) -> getPaymentTime($calcStartDate, $startDate, $maturityDate, $lease);

        /**
         * Price get increase interval
         */
        $priceIncreaseInterval = $request -> price_increase_interval;
        $leasePaymentAmounts['fixed_amount'] = $request -> lease_payment_amount;
        $leasePaymentAmounts['fees'] = $request -> fees;
        $paymentDates = self :: calculateNegotiatePrice($paymentDates, $dateOfFirstPriceIncrease,
            $negotiatePriceIncreasePercent, $negotiatePriceIncreaseAmount, $leasePaymentAmounts, $lease, $priceIncreaseInterval);


        return array($paymentDates, $lease, $calcStartDate, $fees);
    }

    public static function calculateNegotiatePrice($paymentDates, $dateOfFirstPriceIncrease, $negotiatePriceIncreasePercent,
                                                   $negotiatePriceIncreaseAmount, $leasePaymentAmounts, $lease, $priceIncreaseInterval = 12)
    {
        foreach($paymentDates as $key => $value) {
            $paymentDates[$key]['fixed_amount'] = $leasePaymentAmounts['fixed_amount'];
            $paymentDates[$key]['fees'] = $leasePaymentAmounts['fees'];
        }

        if(round($negotiatePriceIncreasePercent)) {
            $paymentDates = (new self) -> addExtraPaymentPercent($dateOfFirstPriceIncrease, $paymentDates,
                $leasePaymentAmounts, $negotiatePriceIncreasePercent, $priceIncreaseInterval, $lease -> leaseType -> extra_payment_in_fees);
        } elseif(round($negotiatePriceIncreaseAmount)) {
            $paymentDates = (new self) -> addExtraPaymentAmount($dateOfFirstPriceIncrease, $paymentDates,
                $leasePaymentAmounts, $negotiatePriceIncreaseAmount, $priceIncreaseInterval);
        }
        $totalNumber = count($paymentDates);

        if($lease -> leaseType -> payment_type == 'Advance' && $lease -> lease_flow_per_year != 12) {
            $paymentDates[$totalNumber - 1]['fixed_amount'] = 0;
            $paymentDates[$totalNumber - 1]['fees'] = 0;
        }

        return $paymentDates;
    }

    public function addFromExcel(float $negotiatePriceIncreasePercent = 0, int $priceIncreaseInterval = 12, string $dateOfFirstPriceIncrease = null)
    {
        $calcStartDate = $this -> lease -> effective_date;
        $startDate = $this -> lease -> first_payment_date;
        $dateOfFirstPriceIncrease = $dateOfFirstPriceIncrease ?: $calcStartDate;
        $leasePaymentAmounts['fixed_amount'] = $this -> lease -> lease_amount;
        $leasePaymentAmounts['fees'] = $this -> lease -> lease_service_cost;
        $maturityDate = Carbon ::parse($this -> lease -> maturity_date) -> toDateString();
        $paymentDates = (new self) -> getPaymentTime($calcStartDate, $startDate, $maturityDate, $this -> lease);
        $paymentDates = self :: calculateNegotiatePrice($paymentDates, $dateOfFirstPriceIncrease, $negotiatePriceIncreasePercent, 0, $leasePaymentAmounts, $this -> lease, $priceIncreaseInterval);
        return $paymentDates;

    }

    public function getPaymentTime($calcStartDate, $firstFlowEndDate, $maturityDate, $lease)
    {

        switch($calcStartDate){
            case 'On Maturity Date':
                $paymentDates = static ::onMaturityDate($calcStartDate, $firstFlowEndDate, $maturityDate, $lease);
                break;

            case 'IMM Dates':
                $paymentDates = static ::getIMMDates($calcStartDate, $firstFlowEndDate, $maturityDate, $lease);
                break;

            default:
                $months = 12 / $lease -> lease_flow_per_year;
                $paymentDates = static ::getDates($calcStartDate, $firstFlowEndDate, $maturityDate, $months, $lease);
                break;

        }
        return $paymentDates;
    }

    /**
     * @param $calcStartDate
     * @param $firstFlowEndDate
     * @param $maturityDate
     * @param $months
     * @param $lease
     * @return array
     */
    protected static function getDates($calcStartDate, $firstFlowEndDate, $maturityDate, $months, $lease)
    {
        $businessDayConvention = $lease -> leaseType -> businessDayConvention;
        $paymentDay = $lease -> payment_day;

        if(LeaseFlowService ::checkAdvanceAndNoTwelveFlows($lease)) {
            $paymentMonth = 1;
            $firstFlowEndDate = Carbon ::parse($firstFlowEndDate) -> subMonthsNoOverflow(1) -> endOfMonth() -> toDateString();
            $returnArray = (new self) -> gettingDate($calcStartDate, $firstFlowEndDate, $maturityDate, $months, $businessDayConvention, $paymentDay, $paymentMonth);
        } else {
            $returnArray = (new self) -> gettingDate($calcStartDate, $firstFlowEndDate, $maturityDate, $months, $businessDayConvention, $paymentDay);
        }

        return $returnArray;
    }

    /**
     * @param $calcStartDate
     * @param $startDate
     * @param $maturityDate
     * @param $lease
     * @return array
     *
     * Needs fixing if used
     */
    protected static function getIMMDates($calcStartDate, $startDate, $maturityDate, $lease)
    {
        $businessDayConvention = $lease -> leaseType -> businessDayConvention;
        $paymentDay = $lease -> payment_day;
        $returnArray = (new self) -> gettingIMMDate($calcStartDate, $startDate, $maturityDate, $businessDayConvention, $paymentDay);
        return $returnArray;
    }

    /**
     * @param $calcStartDate
     * @param $startDate
     * @param $maturityDate
     * @param $lease
     * @return array
     *
     *   Needs fixing if used
     */
    protected static function onMaturityDate($calcStartDate, $startDate, $maturityDate, $lease)
    {
        $businessDayConvention = $lease -> leaseType -> businessDayConvention;
        $paymentDay = $lease -> payment_day;
        $returnArray = (new self) -> gettingDateForMaturity($calcStartDate, $startDate, $maturityDate, $businessDayConvention, $paymentDay);
        return $returnArray;
    }

    /**
     * @return mixed
     */
    public function getLease()
    {
        return $this -> lease;
    }

    /**
     * @param Lease $lease
     * @return $this
     */
    public function setLease(Lease $lease)
    {
        $this -> lease = $lease;
        return $this;
    }

}