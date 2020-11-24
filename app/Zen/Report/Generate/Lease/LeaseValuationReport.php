<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 15/01/2019
 * Time: 16.20
 */

namespace App\Zen\Report\Generate\Lease;


use App\Zen\Lease\Calculate\IFRS\LeaseDiscount;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Report\Generate\GetCurrencyForLease;
use Illuminate\Support\Carbon;

class LeaseValuationReport extends GetCurrencyForLease
{

    public function generateReport()
    {

        $startDate = request() -> end_date ?: Carbon ::today() -> toDateString();
        $leaseIdArray = Lease ::has('leaseFlow') -> where('effective_date', '<', $startDate) -> where('maturity_date', '>', $startDate) -> reportable() -> where('calculate_valuation', 1) -> get();
        foreach($leaseIdArray as $lease) {
            $leaseFlows = LeaseFlow ::with('lease', 'lease.entity') -> where('payment_date', '>', $startDate) -> where('lease_id', $lease -> id) -> get();

            $lastFlowPresent = LeaseFlowService ::leaseFlowPresent($lease, $startDate);
            if(!$lastFlowPresent) {
                $lastFlowPresentWithOpening = LeaseFlowService ::leaseFlowPresentWithOpening($lease -> id, Carbon ::parse($startDate) -> subDay() -> toDateString());
                $lease -> total_liability = $lastFlowPresentWithOpening -> liability_opening_balance;
            } else {
                $lease -> total_liability = $lastFlowPresent -> liability_closing_balance;
            }
            $lease -> total_liability_base_currency = $this -> checkBaseCurrencyAndConvert($lease, $lease -> total_liability, $startDate);

            /*Calculating discount instrument*/
            $i = 0;
            $discountInstrument = 0;
            foreach($leaseFlows as $leaseFlow) {
                $attr['fixed_amount'] = $leaseFlow -> fixed_payment;
                $attr['start_date'] = $leaseFlow -> leaseExtension -> date_of_change;
                $attr['end_date'] = $lease -> maturity_date;
                $discountInstrumentCal = (new LeaseDiscount($lease)) -> calculateValue($lease -> leaseType -> lease_valuation_rate,
                    $attr, ++$i, $lease -> lease_flow_per_year);
                $discountInstrument += $discountInstrumentCal;
            }
            $variableSum = $lease -> exercise_price + $lease -> residual_value_guarantee + $lease -> penalties_for_terminating;
            $parameter['fixed_amount'] = $variableSum;
            $parameter['start_date'] = $lease -> effective_date;
            $parameter['end_date'] = $lease -> maturity_date;
            $variableSumDiscount = (new LeaseDiscount($lease)) -> calculateValue($lease -> leaseType -> lease_valuation_rate, $parameter, $i, $lease -> lease_flow_per_year);
            $lease -> discount_instrument = $discountInstrument + $variableSumDiscount;

            if($lease -> currency_id == $lease -> entity -> currency_id) {
                $lease -> discount_instrument_base_currency = $lease -> discount_instrument;
                $totalValuationAttribute = $lease -> total_liability_base_currency;
            } else {
                $lease -> discount_instrument_base_currency = $this -> checkBaseCurrencyAndConvert($lease,
                    $lease -> discount_instrument, $startDate);
                $totalValuationAttribute = $this -> getAmountLiabilityConversionRate($lease, $lease -> total_liability, $startDate);
            }
            /*End of calculating discount instrument*/

            $lease -> currency_valuation = $this -> calculateMonthlyLiability($lease, $lease -> total_liability, $startDate);
            $lease -> total_valuation = $totalValuationAttribute - $lease -> discount_instrument_base_currency;
            $lease -> price_difference = $lease -> total_valuation - $lease -> currency_valuation;
        }

        $leases = $leaseIdArray;
        if(app('costCenterSplitAdmin')) {
            $leases = $this -> addCostCenterSplit($leaseIdArray);
        }

        return array($startDate, $leases);

    }

    /**
     * @param $leases
     * @return array $leases
     */
    public function addCostCenterSplit($leases)
    {
        $i = 0;
        $arrayToConvert = ['total_liability', 'total_liability_base_currency', 'discount_instrument', 'discount_instrument_base_currency', 'currency_valuation', 'price_difference', 'total_valuation'];
        foreach($leases as $lease) {
            if($lease -> cost_center_split) {
                foreach($lease -> costCenters as $item) {

                    if(!empty(request() -> input('cost_center_id')) && !in_array($item -> id, request() -> input('cost_center_id')))
                        continue;

                    $newFlow = clone $lease;
                    foreach($arrayToConvert as $data) {
                        $newFlow -> $data = $lease -> $data * $item -> pivot -> percentage / 100;
                    }
                    $newFlow -> cost_center_name = $item -> short_name;
                    $leases -> push($newFlow);
                }
                $leases -> forget([$i]);
            }
            $i++;
        }
        return $leases;
    }

}