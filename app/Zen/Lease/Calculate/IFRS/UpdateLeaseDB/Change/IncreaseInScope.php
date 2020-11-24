<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 21/05/2018
 * Time: 12.26
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change;


use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEdited;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Service\LeaseFlowService;

class IncreaseInScope extends LeaseEdited
{

    public function updateDepreciation()
    {
        $depreciationOpeningBalance = $this -> calculateAmountOfDepreciation($this -> extensionId);
        $this -> amountOfDepreciation($this -> lease, $depreciationOpeningBalance);
    }

    public function updateLiability()
    {
        $this -> updateLeaseLiability($this -> getLeaseFlows(), $this -> leaseLiabilityOpeningBalance());
    }

    function calculateAmountOfDepreciation($extensionId)
    {
        $this -> extensionId = $extensionId;
        $leaseExtension = LeaseExtension ::findOrFail($extensionId);
        $variationSum = $this -> leaseLiabilityOpeningBalance();
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> lease, $leaseExtension -> date_of_change);
        $lastDepreciationCLosing = $this -> lastDepreciationCalculation($lastFlow, $leaseExtension);
        $depreciationOpeningBalance = ($variationSum + $lastDepreciationCLosing - $lastFlow -> liability_closing_balance);
        return $depreciationOpeningBalance;
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
        $endDate = request() -> extension_end_date;
        $this -> updateLeaseFlowExtension($this -> lease, $endDate);
    }

    public function updateConversionRate()
    {
        parent ::updateConversionRate();
    }
}