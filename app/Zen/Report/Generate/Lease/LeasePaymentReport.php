<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/05/2018
 * Time: 14.38
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Report\Generate\GetCurrencyForLease;
use App\Zen\Setting\Model\Counterparty;

class LeasePaymentReport extends GetCurrencyForLease
{
    protected $rate = [];

    public function generateReport()
    {

        $startDate = request() -> start_date;
        $endDate = request() -> end_date;

        return $this -> getLeaseMonthData($startDate, $endDate);
    }

    public function getLeaseMonthData($startDate, $endDate)
    {
        set_time_limit(1500);
        $currencies = $this -> eligibleLeaseReport($startDate, $endDate) -> distinct() -> pluck('currency_id') -> toArray();
        $leaseFlows = collect();

        if(request() -> currency_id) {
            $this -> setBaseCurrencyId(request() -> currency_id);
            foreach($currencies as $currency) {
                $leaseIdArray = $this -> eligibleLeaseReport($startDate, $endDate) -> reportable() -> where('currency_id', '=', $currency) -> pluck('id') -> toArray();
                $this -> setcrossCurrencyId($currency);

                $leaseFlowValues = LeaseFlow ::with('lease', 'lease.entity', 'lease.costCenters') -> whereBetween('payment_date',
                    [$startDate, $endDate]) -> whereIn('lease_id', $leaseIdArray) -> orderBy('payment_date') -> get();
                if($this -> baseCurrencyId == $currency) {
                    $leaseFlowValues = $this -> setVariableCurrencyRequest($leaseFlowValues);
                } else {
                    $leaseFlowValues = $this -> convertLeaseFlowAttrWithCur($leaseFlowValues);
                }
                $leaseFlows = $leaseFlows -> merge($leaseFlowValues);
            }
        } else {
            $entities = $this -> eligibleLeaseReport($startDate, $endDate) -> reportable() -> distinct() -> pluck('entity_id') -> toArray();
            foreach($entities as $entityId) {

                $entity = Counterparty ::findOrFail($entityId);
                $this -> setBaseCurrencyId($entity -> currency_id);

                foreach($currencies as $currency) {
                    $leaseIdArray = $this -> eligibleLeaseReport($startDate, $endDate) -> reportable() -> where('currency_id', $currency) -> where('entity_id', $entityId) -> pluck('id') -> toArray();
                    $this -> setcrossCurrencyId($currency);

                    $leaseFlowValues = LeaseFlow ::with('lease', 'lease.entity', 'lease.costCenters') -> whereBetween('payment_date',
                        [$startDate, $endDate]) -> whereIn('lease_id', $leaseIdArray) -> orderBy('payment_date') -> get();
                    if($this -> baseCurrencyId == $currency) {
                        $leaseFlowValues = $this -> setVariable($leaseFlowValues);
                    } else {
                        $leaseFlowValues = $this -> convertLeaseFlowAttr($leaseFlowValues);
                    }
                    $leaseFlows = $leaseFlows -> merge($leaseFlowValues);
                }
            }
        }

        if(app('costCenterSplitAdmin')) {
            $leaseFlows = $this -> addCostCenterSplit($leaseFlows);
        }

        return $leaseFlows;
    }

    public function setVariable($leaseFlows)
    {
        foreach($leaseFlows as $leaseFlow) {
            $leaseFlow = $this -> setConversionNoDiff($leaseFlow);
            $leaseFlow -> realised_fx_difference = 0;
        }
        return $leaseFlows;
    }

    public function setVariableCurrencyRequest($leaseFlows)
    {
        foreach($leaseFlows as $leaseFlow) {
            $leaseFlow = $this -> setConversionNoDiff($leaseFlow);
            if($this -> checkConditionForRealisedFXWithCurrency($leaseFlow)) {
                $leaseFlow -> realised_fx_difference = $this -> calculateFxDifference($leaseFlow);
            } else {
                $leaseFlow -> realised_fx_difference = 0;
            }
        }
        return $leaseFlows;
    }

    public function setConversionNoDiff($leaseFlow)
    {
        $leaseFlow -> fixed_payment_base_currency = $leaseFlow -> fixed_payment;
        $leaseFlow -> fees_base_currency = $leaseFlow -> fees;
        $leaseFlow -> interest_cost_base_currency = $leaseFlow -> interest_cost;
        $leaseFlow -> total_base_currency = $leaseFlow -> total_payment;
        $leaseFlow -> repayment_base_currency = $leaseFlow -> repayment;
        return $leaseFlow;
    }

    public function convertLeaseFlowAttr($leaseFlows)
    {
        foreach($leaseFlows as $leaseFlow) {
            $leaseFlow -> fixed_payment_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fixed_payment, $leaseFlow -> payment_date);
            $leaseFlow -> fees_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fees, $leaseFlow -> payment_date);
            $leaseFlow -> depreciation_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> depreciation, $leaseFlow -> payment_date);
            $leaseFlow -> interest_cost_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> interest_cost, $leaseFlow -> payment_date);
            $leaseFlow -> total_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> total_payment, $leaseFlow -> payment_date);
            $leaseFlow -> repayment_base_currency = $this -> repaymentBaseCurrency($leaseFlow);
            if($this -> checkConditionForRealisedFx($leaseFlow)) {
                $leaseFlow -> realised_fx_difference = $this -> calculateFxDifference($leaseFlow);
            }
        }

        return $leaseFlows;
    }

    public function repaymentBaseCurrency($leaseFlow)
    {
        return $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> repayment, $leaseFlow -> payment_date);
    }

    public function convertLeaseFlowAttrWithCur($leaseFlows)
    {
        foreach($leaseFlows as $leaseFlow) {
            $leaseFlow -> fixed_payment_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fixed_payment, $leaseFlow -> payment_date);
            $leaseFlow -> fees_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> fees, $leaseFlow -> payment_date);
            $leaseFlow -> depreciation_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> depreciation, $leaseFlow -> payment_date);
            $leaseFlow -> interest_cost_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> interest_cost, $leaseFlow -> payment_date);
            $leaseFlow -> total_base_currency = $this -> checkBaseCurrencyAndConvert($leaseFlow -> lease, $leaseFlow -> total_payment, $leaseFlow -> payment_date);
            $leaseFlow -> repayment_base_currency = $this -> repaymentBaseCurrency($leaseFlow);
            if($this -> checkConditionForRealisedFXWithCurrency($leaseFlow)) {
                $leaseFlow -> realised_fx_difference = $this -> calculateFxDifference($leaseFlow);
            }
        }

        return $leaseFlows;
    }

    public function checkConditionForRealisedFx($leaseFlow)
    {
        return $this -> crossCurrencyId != $this -> baseCurrencyId && $leaseFlow -> leaseExtension -> liability_conversion_rate;

    }

    public function calculateFxDifference($leaseFlow)
    {
        return ($leaseFlow -> repayment / $leaseFlow -> leaseExtension -> liability_conversion_rate) - $leaseFlow -> repayment_base_currency;

    }

    private function checkConditionForRealisedFXWithCurrency($leaseFlow)
    {
        return $this -> crossCurrencyId !== $leaseFlow -> lease -> entity -> currency_id && $leaseFlow -> leaseExtension -> liability_conversion_rate && $this -> baseCurrencyId == $leaseFlow -> lease -> entity -> currency_id;
    }

    /**
     * @param $leaseFlows
     * @return array $leaseFlows
     */
    public function addCostCenterSplit($leaseFlows)
    {
        $i = 0;
        $arrayToConvert = ['fixed_payment_base_currency', 'fixed_payment', 'total_payment', 'total_base_currency', 'fees_base_currency', 'fees', 'repayment', 'repayment_base_currency', 'interest_cost_base_currency', 'interest_cost', 'realised_fx_difference'];
        foreach($leaseFlows as $leaseFlow) {
            if($leaseFlow -> lease -> cost_center_split && count($leaseFlow -> lease -> costCenters)) {
                foreach($leaseFlow -> lease -> costCenters as $item) {

                    if(!empty(request() -> input('cost_center_id')) && !in_array($item -> id, request() -> input('cost_center_id')))
                        continue;

                    $newFlow = clone $leaseFlow;
                    foreach($arrayToConvert as $data) {
                        $newFlow -> $data = $leaseFlow -> $data * $item -> pivot -> percentage / 100;
                    }
                    $newFlow -> percentage = $item -> pivot -> percentage / 100 ;
                    $newFlow -> cost_center_name = $item -> short_name;
                    $leaseFlows -> push($newFlow);
                }
                $leaseFlows -> forget([$i]);
            }
            $i++;
        }

        return $leaseFlows;
    }
}