<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 21/05/2018
 * Time: 12.29
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change;


use App\Zen\Lease\Calculate\IFRS\LeaseDiscount;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEdited;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use Carbon\Carbon;

class DecreaseInTerm extends LeaseEdited
{

    public function updateDepreciation()
    {
        if($this -> extensionId) {
            $depreciationOpeningBalance = $this -> calculateAmountOfDepreciation($this -> extensionId);
            $this -> amountOfDepreciation($this -> lease, $depreciationOpeningBalance);
        }
    }

    public function updateLiability()
    {
        if($this -> extensionId) {
            $this -> updateLeaseLiability($this -> getLeaseFlows(), $this -> leaseLiabilityOpeningBalance());
        }
    }

    public function calculateAmountOfDepreciation($extensionId)
    {
        $leaseExtension = LeaseExtension ::findOrFail($extensionId);
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> lease, $leaseExtension -> date_of_change);
        $lastDepreciationClosing = $this -> lastDepreciationCalculation($lastFlow, $leaseExtension);
        $depreciationOpeningBalance = $lastDepreciationClosing - $this -> changeInAsset($lastFlow, $leaseExtension) + $this -> adjustmentToLiability($lastFlow, $this -> extensionId);
        return $depreciationOpeningBalance;
    }

    public function changeInLiability($lastFlow, $extensionId)
    {
        $previousExtension = LeaseExtensionService ::earlierExtension($extensionId);
        $leaseExtension = LeaseExtension ::findOrFail($extensionId);
        $leaseFlows = LeaseFlowService ::leaseFlowsWithDelete($leaseExtension -> lease, $leaseExtension -> id);
        $totalLeaseFlows = LeaseFlow ::where('end_date', '<', $leaseExtension -> extension_start_date) -> where('lease_id', $leaseExtension -> lease_id) -> get();
        $i = count($totalLeaseFlows);
        if($this -> lease -> lease_flow_per_year == 12 && $this -> lease -> leaseType -> payment_type == 'Advance' && $this -> lease -> leaseType -> exclude_first_payment)
            $i = count($totalLeaseFlows) - 1;
        $sumRemainingDiscountedCashFlow = 0;
        foreach($leaseFlows as $leaseFlow) {
            $attr['fixed_amount'] = $leaseFlow -> fixed_payment;
            $attr['start_date'] = $leaseFlow -> leaseExtension -> date_of_change;
            $attr['end_date'] = $leaseFlow -> end_date;
            $discountedInstrument = (new LeaseDiscount($leaseExtension -> lease)) -> calculateValue($previousExtension -> lease_extension_rate,
                $attr, ++$i, $leaseExtension -> lease -> lease_flow_per_year);
            $sumRemainingDiscountedCashFlow = $sumRemainingDiscountedCashFlow + $discountedInstrument;
        }

        $oldLiability = $lastFlow -> liability_closing_balance;
        $changeInLiability = $oldLiability - $sumRemainingDiscountedCashFlow;
        return $changeInLiability;
    }

    public function changeInLiabilityWithVariationSum($lastFlow, $extensionId)
    {
        $changeInLiability = self ::changeInLiability($lastFlow, $extensionId);
        $variationSum = LeaseFlowService ::calculateLeaseEndPaymentsDiscount($lastFlow -> lease, $extensionId);
        return $changeInLiability - $variationSum;
    }

    public function changeInAsset($lastFlow, $leaseExtension)
    {
        $oldDepreciation = $this -> lastDepreciationCalculation($lastFlow, $leaseExtension);

        $initialTerm = Carbon ::parse($lastFlow -> end_date) -> diffInDays(Carbon ::parse($lastFlow -> leaseExtension -> extension_end_date));
        $finalTerm = Carbon ::parse($lastFlow -> end_date) -> diffInDays(Carbon ::parse($leaseExtension -> extension_end_date));

        $newAssetValue = $oldDepreciation / $initialTerm * $finalTerm;

        $changeInAsset = $oldDepreciation - $newAssetValue;
        return $changeInAsset;
    }

    public function adjustmentToLiability($lastFlow, $extensionId)
    {
        $leaseExtension = LeaseExtension ::findOrFail($extensionId);
        $leaseExtensionFirstFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($leaseExtension -> lease, $leaseExtension -> id);
        $lastLiabilityClosing = $lastFlow -> liability_closing_balance;
        $newLiabilityOpening = $leaseExtensionFirstFlow -> liability_opening_balance;
        $changeInLiabilty = $this -> changeInLiabilityWithVariationSum($lastFlow, $extensionId);
        $adjustmentToLiability = $newLiabilityOpening - $lastLiabilityClosing + $changeInLiabilty;
        return $adjustmentToLiability;
    }

    public function getLeaseFlows()
    {
        $leaseFlows = LeaseFlowService ::leaseFlowsNoDepreciation($this -> lease, $this -> extensionId);
        return $leaseFlows;
    }

    public function leaseLiabilityOpeningBalance()
    {
        $leaseLiabilityOpeningBalance = LeaseFlowService ::leaseLiabilityOpeningBalance($this -> lease, $this -> extensionId);
        return $leaseLiabilityOpeningBalance;
    }

    public function updateLeaseFlows()
    {
        $this -> updateLeaseFlowExtension($this -> lease, null);
    }

    public function getInitialTerm($lastFlow)
    {
        $initialTerm = Carbon ::parse($lastFlow -> end_date) -> diffInDays(Carbon ::parse($this -> lease -> maturity_date));
        return $initialTerm;

    }

    public function getFinalTerm($lastFlow, $lastLeaseFlowWithExtension)
    {
        $finalTerm = Carbon ::parse($lastFlow -> end_date) -> diffInDays(Carbon ::parse($lastLeaseFlowWithExtension -> end_date));
        return $finalTerm;

    }

    public function updateConversionRate()
    {
        parent ::updateConversionRate();
    }

}