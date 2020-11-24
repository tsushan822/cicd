<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/07/2018
 * Time: 13.49
 */

namespace App\Zen\Setting\Calculate\Generate;


use App\Zen\Setting\Calculate\DateTime\BusinessDateConvention;
use App\Zen\Setting\Calculate\DateTime\IMMDate;
use App\Zen\Setting\Calculate\DateTime\Traits\PaymentDayCalculation;
use Carbon\Carbon;

abstract class GenerateFlow
{
    use PaymentDayCalculation;

    public function gettingIMMDate($calcStartDate, $startDate, $maturityDate, $businessDayConvention, $paymentDay = 30, $paymentMonth = 0)
    {
        $paymentDates = (new IMMDate()) -> gettingIMMDate($startDate, $maturityDate);

        $i = 1;
        $returnArray = array();

        //For first payment
        $startDate = (Carbon ::parse($startDate)) -> toDateString();
        $returnArray[0]['start_date'] = $calcStartDate;
        $returnArray[0]['end_date'] = $startDate;
        $returnArray[0]['payment_date'] = $this -> getPaymentDate($startDate, $paymentDay, $businessDayConvention, $paymentMonth);

        //Other payment dates
        foreach($paymentDates as $paymentDate) {

            $returnArray[$i]['start_date'] = $startDate;
            $startDate = $paymentDate;
            $returnArray[$i]['end_date'] = $startDate;
            $returnArray[$i]['payment_date'] = $this -> getPaymentDate($startDate, $paymentDay, $businessDayConvention, $paymentMonth);
            $i++;
        }
        return $returnArray;

    }

    public function gettingDate($calcStartDate, $startDate, $maturityDate, $months, $businessDayConvention, $paymentDay = 30, $paymentMonth = 0)
    {
        $i = 1;
        $returnArray = array();

        //For first payment
        $startDate = (Carbon ::parse($startDate)) -> toDateString();
        $returnArray[0]['start_date'] = $calcStartDate;
        $returnArray[0]['end_date'] = $startDate;
        $returnArray[0]['payment_date'] = $this -> getPaymentDate($startDate, $paymentDay, $businessDayConvention, $paymentMonth);

        //Other payment dates
        while ($startDate < $maturityDate) {
            $returnArray[$i]['start_date'] = $startDate;
            $startDate = (Carbon ::parse($startDate)) -> addMonthsNoOverflow($months) -> endOfMonth() -> toDateString();
            $startDate = $startDate < $maturityDate ? $startDate : $maturityDate;
            $returnArray[$i]['end_date'] = $startDate;
            $returnArray[$i]['payment_date'] = $this -> getPaymentDate($startDate, $paymentDay, $businessDayConvention, $paymentMonth);
            $i++;
        }
        return $returnArray;
    }

    public function getPaymentDate($date, $paymentDay, $businessDayConvention, $paymentMonth = 0)
    {
        $paymentDate = self ::paymentDayCalculationWithMonthAdjustment($date, $paymentDay, $paymentMonth);
        $paymentDate = (new BusinessDateConvention()) -> convertDateWithBusinessDayConvention($businessDayConvention, $paymentDate);
        return $paymentDate;
    }

    public function gettingDateForMaturity($calcStartDate, $startDate, $maturityDate, $businessDayConvention, $paymentDay = 30, $paymentMonth = 0)
    {
        $startDate = (Carbon ::parse($startDate)) -> toDateString();
        $returnArray[0]['start_date'] = $calcStartDate;
        $returnArray[0]['end_date'] = $startDate;
        $returnArray[0]['payment_date'] = $this -> getPaymentDate($startDate, $paymentDay, $businessDayConvention, $paymentMonth);

        $returnArray[1]['start_date'] = $startDate;
        $returnArray[1]['end_date'] = $maturityDate;
        $returnArray[1]['payment_date'] = $this -> getPaymentDate($maturityDate, $paymentDay, $businessDayConvention, $paymentMonth);

        return $returnArray;
    }

    /**
     * @param $calculationStartDate
     * @param $arrayWithFlowDetails
     * @param $amount
     * @param $addedAmount
     * @param int $months
     * @param bool $feePriceIncrease
     * @return mixed
     */
    public function addExtraPaymentAmount($calculationStartDate, $arrayWithFlowDetails, $amount, $addedAmount, $months = 12)
    {
        for($i = 0; $i < count($arrayWithFlowDetails); $i++) {

            //Because before date shouldn't be checked
            if($calculationStartDate > $arrayWithFlowDetails[$i]['start_date']) {
                continue;
            }

            /*
             * Here a day is added because it cannot be make since the start date is end of last month
            */
            $difference = intval(Carbon ::parse($calculationStartDate) -> diffInMonths(addADay($arrayWithFlowDetails[$i]['start_date'])) / $months) + 1;
            $arrayWithFlowDetails[$i]['fixed_amount'] = $difference * $addedAmount + $amount['fixed_amount'];


            $present = false;
            if(request() -> payment_month)
                $present = array_search(Carbon ::parse($arrayWithFlowDetails[$i]['payment_date']) -> endOfMonth() -> toDateString(), arrayDateToLastOfMonth(request() -> payment_month));
            if($present) {
                $arrayWithFlowDetails[$i]['fixed_amount'] = request('payment_value')[$present];
                $arrayWithFlowDetails[$i]['fees'] = request('payment_service_cost')[$present];
            }
        }
        return $arrayWithFlowDetails;
    }

    /**
     * @param $calculationStartDate
     * @param $arrayWithFlowDetails
     * @param $amount
     * @param $addedPercent
     * @param int $months
     * @param bool $feePriceIncrease
     * @return mixed
     */
    public function addExtraPaymentPercent($calculationStartDate, $arrayWithFlowDetails, $amount, $addedPercent, $months = 12, $feePriceIncrease = false)
    {
        $value['fixed_amount'] = $amount['fixed_amount'];
        $value['fees'] = $amount['fees'];
        $calculationStartDate = Carbon ::parse($calculationStartDate) -> subMonths($months) -> toDateString();
        for($i = 0; $i < count($arrayWithFlowDetails); $i++) {

            //Because before date shouldn't be checked
            if($calculationStartDate > $arrayWithFlowDetails[$i]['start_date']) {
                continue;
            }

            $difference = intval(Carbon ::parse($calculationStartDate) -> diffInMonths(addADay($arrayWithFlowDetails[$i]['start_date'])) / $months);
            if($difference) {
                $value['fixed_amount'] = $addedPercent / 100 * $value['fixed_amount'] + $value['fixed_amount'];
                $value['fees'] = $addedPercent / 100 * $value['fees'] + $value['fees'];
                $calculationStartDate = $arrayWithFlowDetails[$i]['start_date'];
            }

            $arrayWithFlowDetails[$i]['fixed_amount'] = $value['fixed_amount'];

            //Add price increase if it is yes in lease type
            if($feePriceIncrease)
                $arrayWithFlowDetails[$i]['fees'] = $value['fees'];

            $present = false;
            if(request() -> payment_month)
                $present = array_search(Carbon ::parse($arrayWithFlowDetails[$i]['payment_date']) -> endOfMonth() -> toDateString(), arrayDateToLastOfMonth(request() -> payment_month));
            if($present) {
                $arrayWithFlowDetails[$i]['fixed_amount'] = request('payment_value')[$present];
                $arrayWithFlowDetails[$i]['fees'] = request('payment_service_cost')[$present];
            }
        }
        return $arrayWithFlowDetails;
    }
}