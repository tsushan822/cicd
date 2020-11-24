<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/05/2018
 * Time: 10.40
 */

namespace App\Zen\Report\Generate\Lease;

use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\DecreaseInTerm;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change\TerminateLease;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEditView;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Report\Generate\GetCurrencyForLease;
use App\Zen\Setting\Service\Currency\CurrencyConversion;

class LeaseChangeReport extends GetCurrencyForLease
{

    public $leaseFlowChanges;

    /**
     * LeaseChangeReport constructor.
     */
    public function __construct()
    {
        $this -> leaseFlowChanges = collect();
    }

    public function generateReport()
    {
        set_time_limit(1500);
        $startDate = request() -> get('start_date');
        $endDate = request() -> get('end_date');

        return $this -> getLeaseChangeData($startDate, $endDate);
    }

    public function getLeaseChangeData($startDate, $endDate)
    {

        $leaseIdArray = Lease ::reportable() -> pluck('id') -> toArray();
        $leaseExtensionQ = LeaseExtension :: with('lease', 'lease.entity', 'firstLeaseFlow', 'lease.costCenter',
            'lease.portfolio', 'lease.currency', 'lease.leaseType') -> whereBetween('date_of_change', [$startDate, $endDate])
            -> whereIn('lease_id', $leaseIdArray) -> orderBy('extension_start_date');

        $leaseExtensionQ -> chunk(800, function ($chunks) {
            foreach($chunks as $item) {
                $lease = $item -> lease;
                switch($item -> lease_extension_type){
                    case 'Decrease In Scope':
                        $this -> decreaseInScopeChanges($item, $lease);
                        break;
                    case 'Increase In Scope':
                        $this -> increaseInScopeChanges($item, $lease);
                        break;
                    case 'Decrease In Term':
                        $this -> decreaseInTermChanges($item, $lease);
                        break;
                    case 'Terminate Lease':
                        $this -> terminateChange($item, $lease);
                        break;
                    default:
                        $this -> initialChange($item, $lease);
                        break;
                }
            }
        });


        foreach($this -> leaseFlowChanges as $item) {
            if($item -> liability_opening_balance_base_currency > 0) {
                $item -> liability_opening_balance_addition = $item -> liability_opening_balance_base_currency;
                $item -> liability_opening_balance_decrease = 0;
            } else {
                $item -> liability_opening_balance_addition = 0;
                $item -> liability_opening_balance_decrease = $item -> liability_opening_balance_base_currency;
            }

            if($item -> depreciation_opening_balance_base_currency > 0) {
                $item -> depreciation_opening_balance_addition = $item -> depreciation_opening_balance_base_currency;
                $item -> depreciation_opening_balance_decrease = 0;
            } else {
                $item -> depreciation_opening_balance_addition = 0;
                $item -> depreciation_opening_balance_decrease = $item -> depreciation_opening_balance_base_currency;
            }
        }

        $leaseChanges = $this -> leaseFlowChanges;
        if(app('costCenterSplitAdmin')) {
            $leaseChanges = $this -> addCostCenterSplit($leaseChanges);
        }

        return $leaseChanges;
    }

    private
    function decreaseInScopeChanges($leaseExtension, $lease)
    {
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($lease, $leaseExtension -> date_of_change);
        $percent = $leaseExtension -> decrease_in_scope_rate;
        $liabilityOpening = (($lastFlow -> liability_closing_balance) * $percent / 100);

        /**************Since we need two row for lease decrease in scope *********************/
        $differenceWithDecreasedScope = ($leaseExtension -> firstLeaseFlow -> liability_opening_balance + $liabilityOpening) - ($lastFlow -> liability_closing_balance);

        $this -> createLeaseFlowChange($lease, $leaseExtension, $differenceWithDecreasedScope, $differenceWithDecreasedScope);


        $percent = $leaseExtension -> decrease_in_scope_rate;
        $lastLeaseDepreciationClosing = (new LeaseEditView($leaseExtension -> lease)) -> lastDepreciationCalculation($lastFlow, $leaseExtension);
        $assetOpening = ($lastLeaseDepreciationClosing * $percent / 100);
        $assetOpening = (-1) * $assetOpening;
        $liabilityOpening = (-1) * $liabilityOpening;
        $this -> createLeaseFlowChange($lease, $leaseExtension, $liabilityOpening, $assetOpening, true, true);
    }

    private
    function increaseInScopeChanges($leaseExtension, $lease)
    {
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($lease, $leaseExtension -> date_of_change);
        $liabilityOpening = $leaseExtension -> firstLeaseFlow -> liability_opening_balance - ($lastFlow -> liability_closing_balance);
        $assetOpening = $leaseExtension -> firstLeaseFlow -> depreciation_opening_balance - (new LeaseEditView($lease)) -> lastDepreciationCalculation($lastFlow, $leaseExtension);
        if($liabilityOpening < 0) {
            $this -> createLeaseFlowChange($lease, $leaseExtension, $liabilityOpening, $assetOpening);
        } else {
            $leaseFlowChange = [
                'id' => $leaseExtension -> lease_id,
                'entity' => $lease -> entity -> short_name,
                'counterparty' => $lease -> counterparty -> short_name,
                'date_of_change' => $leaseExtension -> date_of_change,
                'lease_type' => $lease -> leaseType -> type,
                'cost_center' => optional($lease -> costCenter) -> short_name,
                'portfolio' => $lease -> portfolio -> name,
                'currency' => $lease -> currency -> iso_4217_code,
                'liability_opening_balance' => $liabilityOpening,
                'liability_opening_balance_base_currency' => $this -> checkBaseCurrencyAndConvert($lease, $liabilityOpening, $leaseExtension -> date_of_change),
                'depreciation_opening_balance' => $assetOpening,
                'depreciation_opening_balance_base_currency' => $this -> checkBaseCurrencyAndConvert($lease, $assetOpening, $leaseExtension -> date_of_change),
                'realised_difference' => 0,
                'realised_fx_difference' => 0,
                'realised_difference_base_currency' => 0,
            ];
            $this -> addChangesToDisplay($leaseFlowChange);
        }
    }

    private
    function decreaseInTermChanges($leaseExtension, $lease)
    {
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($lease, $leaseExtension -> date_of_change);
        $decreaseInTermObject = new DecreaseInTerm($lease);
        $changeInAsset = (-1) * $decreaseInTermObject -> changeInAsset($lastFlow, $leaseExtension);
        $changeInLiability = (-1) * $decreaseInTermObject -> changeInLiabilityWithVariationSum($lastFlow, $leaseExtension -> id);
        $this -> createLeaseFlowChange($lease, $leaseExtension, $changeInLiability, $changeInAsset, true, true);

        $decreaseInTermObj = new DecreaseInTerm($leaseExtension -> lease);
        $liabilityOpening = $decreaseInTermObj -> adjustmentToLiability($lastFlow, $leaseExtension -> id);
        $assetOpening = $liabilityOpening;
        $this -> createLeaseFlowChange($lease, $leaseExtension, $liabilityOpening, $assetOpening);
    }

    public
    function createLeaseFlowChange($lease, $leaseExtension, $liabilityOpening, $assetOpening, $realisedDifference = false, $useFxInAsset = false)
    {
        $useFx = false;
        if(request() -> get('currency_id')) {
            $useFx = request() -> get('currency_id') != $lease -> entity -> currency_id;
        }

        $leaseFlowChange = [
            'id' => $leaseExtension -> lease_id,
            'entity' => $lease -> entity -> short_name,
            'counterparty' => $lease -> counterparty -> short_name,
            'date_of_change' => $leaseExtension -> date_of_change,
            'lease_type' => $lease -> leaseType -> type,
            'cost_center' => optional($lease -> costCenter) -> short_name,
            'portfolio' => $lease -> portfolio -> name,
            'currency' => $lease -> currency -> iso_4217_code,
            'liability_opening_balance' => $liabilityOpening,
            'depreciation_opening_balance' => $assetOpening,
            'realised_difference' => 0,
            'realised_fx_difference' => 0,
            'realised_difference_base_currency' => 0,
        ];

        if($useFxInAsset || $useFx) {
            $leaseFlowChange['liability_opening_balance_base_currency'] = $this -> checkBaseCurrencyAndConvert($lease, $liabilityOpening, $leaseExtension -> date_of_change);
        } else {
            $leaseFlowChange['liability_opening_balance_base_currency'] = $this -> convertInLiabilityRate($liabilityOpening, $leaseExtension, $lease);
        }

        if($useFx) {
            $leaseFlowChange['depreciation_opening_balance_base_currency'] = $this -> checkBaseCurrencyAndConvert($lease, $assetOpening, $leaseExtension -> date_of_change);
        } else {
            $leaseFlowChange['depreciation_opening_balance_base_currency'] = $this -> convertInDepreciationRate($assetOpening, $leaseExtension, $lease);
        }

        if($realisedDifference) {
            if($lease -> currency_id != $lease -> entity -> currency_id && ($leaseExtension -> liability_conversion_rate)) {
                $leaseFlowChange['realised_fx_difference'] = (CurrencyConversion ::currencyAmountToBaseAmount($liabilityOpening, $leaseExtension -> date_of_change, $lease -> entity -> currency, $lease -> currency)) - ($liabilityOpening / $leaseExtension -> liability_conversion_rate);
            }
            $leaseFlowChange['realised_difference'] = $assetOpening - $liabilityOpening;
            $leaseFlowChange['realised_difference_base_currency'] = $leaseFlowChange['depreciation_opening_balance_base_currency'] - $leaseFlowChange['liability_opening_balance_base_currency'];
        }
        $this -> addChangesToDisplay($leaseFlowChange);
    }

    private
    function initialChange($leaseExtension, $lease)
    {
        $liabilityOpening = $leaseExtension -> firstLeaseFlow -> liability_opening_balance;
        $assetOpening = $leaseExtension -> firstLeaseFlow -> depreciation_opening_balance;
        $leaseFlowChange = [
            'id' => $leaseExtension -> lease_id,
            'entity' => $lease -> entity -> short_name,
            'counterparty' => $lease -> counterparty -> short_name,
            'date_of_change' => $leaseExtension -> date_of_change,
            'lease_type' => $lease -> leaseType -> type,
            'cost_center' => optional($lease -> costCenter) -> short_name,
            'portfolio' => $lease -> portfolio -> name,
            'currency' => $lease -> currency -> iso_4217_code,
            'liability_opening_balance' => $liabilityOpening,
            'liability_opening_balance_base_currency' => $this -> checkBaseCurrencyAndConvert($lease, $liabilityOpening),
            'depreciation_opening_balance' => $assetOpening,
            'depreciation_opening_balance_base_currency' => $this -> checkBaseCurrencyAndConvert($lease, $assetOpening),
            'lease_payment_start_date' => $lease -> payment_before_commencement_date,
            'lease_payment_start_date_base_currency' => $this -> checkBaseCurrencyAndConvert($lease, $lease -> payment_before_commencement_date),
            'realised_difference' => 0,
            'realised_fx_difference' => 0,
            'realised_difference_base_currency' => 0,
        ];
        $this -> addChangesToDisplay($leaseFlowChange);
    }

    public
    function addChangesToDisplay($leaseFlowChange)
    {
        $this -> leaseFlowChanges -> push((object)$leaseFlowChange);
    }

    public
    function terminateChange($leaseExtension, $lease)
    {
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($lease, $leaseExtension -> date_of_change);
        $liabilityOpening = (-1) * $lastFlow -> liability_closing_balance;
        $assetOpening = (-1) * (new TerminateLease($leaseExtension -> lease)) -> changeInAsset($lastFlow, $leaseExtension);

        $leaseFlowChange = [
            'id' => $leaseExtension -> lease_id,
            'entity' => $lease -> entity -> short_name,
            'counterparty' => $lease -> counterparty -> short_name,
            'date_of_change' => $leaseExtension -> date_of_change,
            'lease_type' => $lease -> leaseType -> type,
            'cost_center' => optional($lease -> costCenter) -> short_name,
            'portfolio' => $lease -> portfolio -> name,
            'currency' => $lease -> currency -> iso_4217_code,
            'liability_opening_balance' => $liabilityOpening,
            'depreciation_opening_balance' => $assetOpening,
            'depreciation_opening_balance_base_currency' => $this -> convertInDepreciationRate($assetOpening, $leaseExtension, $lease),
            'realised_difference' => 0,
            'realised_fx_difference' => 0,
            'realised_difference_base_currency' => 0,
        ];

        $leaseFlowChange['liability_opening_balance_base_currency'] = $this -> convertInLiabilityRate($liabilityOpening, $leaseExtension, $lease);

        if($lease -> currency_id != $lease -> entity -> currency_id && ($leaseExtension -> liability_conversion_rate)) {
            $leaseFlowChange['realised_fx_difference'] = (CurrencyConversion ::currencyAmountToBaseAmount($liabilityOpening, $leaseExtension -> date_of_change, $lease -> entity -> currency, $lease -> currency)) - ($liabilityOpening / $lastFlow -> leaseExtension -> liability_conversion_rate);
        }
        $leaseFlowChange['realised_difference'] = $assetOpening - $liabilityOpening;
        $leaseFlowChange['realised_difference_base_currency'] = $leaseFlowChange['depreciation_opening_balance_base_currency'] - $leaseFlowChange['liability_opening_balance_base_currency'];

        $this -> addChangesToDisplay($leaseFlowChange);
    }

    public function checkRealisedFXCriteria($lease, $leaseExtension)
    {
        if($lease -> currency_id != $lease -> entity -> currency_id && ($leaseExtension -> liability_conversion_rate)) {
            return request() -> currency_id ? request() -> currency_id == $lease -> entity -> currency_id : true;

        }
        return false;

    }

    /**
     * @param $returnLeases
     *
     * @return array $returnLeases
     */
    public function addCostCenterSplit($returnLeases)
    {
        $i = 0;
        $arrayToConvert = ['liability_opening_balance', 'liability_opening_balance_addition', 'liability_opening_balance_decrease',
            'depreciation_opening_balance', 'depreciation_opening_balance_addition', 'depreciation_opening_balance_decrease',
            'realised_difference', 'realised_difference_base_currency', 'realised_fx_difference', 'liability_opening_balance_base_currency', 'depreciation_opening_balance_base_currency'];
        foreach($returnLeases as $returnLease) {
            $lease = Lease ::findOrFail($returnLease -> id);
            if($lease -> cost_center_split) {
                foreach($lease -> costCenters as $item) {

                    if(!empty(request() -> input('cost_center_id')) && !in_array($item -> id, request() -> input('cost_center_id')))
                        continue;

                    $newFlow = clone $returnLease;
                    foreach($arrayToConvert as $data) {
                        $newFlow -> $data = $returnLease -> $data * $item -> pivot -> percentage / 100;
                    }
                    $newFlow -> percentage = $item -> pivot -> percentage / 100;
                    $newFlow -> cost_center = $item -> short_name;
                    $returnLeases -> push($newFlow);
                }
                $returnLeases -> forget([$i]);
            }
            $i++;
        }

        return $returnLeases;
    }

}