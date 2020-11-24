<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 18/05/2018
 * Time: 9.29
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\Change;


use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEdited;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Service\LeaseFlowService;

class DecreaseInScope extends LeaseEdited
{

    protected $lease;

    /**
     * ExtensionLeaseEditView constructor.
     * @param Lease $lease
     */
    public function __construct(Lease $lease)
    {
        parent::__construct($lease);

    }

    public function updateDepreciation()
    {
        $depreciationOpeningBalance = $this -> calculateAmountOfDepreciation($this -> extensionId);
        $this -> amountOfDepreciation($this -> lease, $depreciationOpeningBalance);
    }

    public function updateLiability()
    {
        $this -> updateLeaseLiability($this -> getLeaseFlows(), $this -> leaseLiabilityOpeningBalance());
    }

    public function calculateAmountOfDepreciation($extensionId)
    {
        $leaseExtension = LeaseExtension ::findOrFail($extensionId);
        $variationSum = $this -> leaseLiabilityOpeningBalance();
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> lease, $leaseExtension -> date_of_change);
        $percent = $leaseExtension -> decrease_in_scope_rate;
        $remainingPercent = 100 - $percent;
        $lastDepreciationClosingBalance = $this -> lastDepreciationCalculation($lastFlow, $leaseExtension);
        $depreciationOpeningBalance = ($variationSum + ($lastDepreciationClosingBalance * $remainingPercent / 100)
            - (($lastFlow -> liability_closing_balance) * $remainingPercent / 100));
        return $depreciationOpeningBalance;
    }

    public function showData()
    {
        $leaseExtension = LeaseExtension ::findOrFail($this -> extensionId);
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> lease, $leaseExtension -> extension_start_date);
        $amtDpct = $this -> calculateAmountOfDepreciation($this -> extensionId);
        return array($amtDpct, $this -> leaseLiabilityOpeningBalance(), $lastFlow);
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
        //$endDate = $this -> lease -> maturity_date;
        $this -> updateLeaseFlowExtension($this -> lease, null);
    }


    public function updateConversionRate()
    {
        parent ::updateConversionRate();
    }

}