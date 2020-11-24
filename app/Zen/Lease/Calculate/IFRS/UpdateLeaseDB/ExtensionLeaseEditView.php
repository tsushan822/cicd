<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 11/05/2018
 * Time: 15.41
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Service\LeaseFlowService;

class ExtensionLeaseEditView extends LeaseEdited
{
    protected $extensionId;
    protected $leaseLiabilityOpeningBalance;

    /**
     * ExtensionLeaseEditView constructor.
     * @param Lease $lease
     * @param $extensionId
     */
    public function __construct(Lease $lease, $extensionId = null)
    {
        parent ::__construct($lease);
        $this -> leaseLiabilityOpeningBalance = LeaseFlowService ::leaseLiabilityOpeningBalance($lease, $extensionId);
        $this -> extensionId = $extensionId;

    }

    public function updateDepreciation()
    {
        $depreciationOpeningBalance = $this -> calculateAmountOfDepreciation();
        $this -> amountOfDepreciation($this -> lease, $depreciationOpeningBalance);
    }

    public function updateLiability()
    {
        $this -> updateLeaseLiability($this -> getLeaseFlows(), $this -> leaseLiabilityOpeningBalance);
    }

    function calculateAmountOfDepreciation()
    {
        $leaseExtension = LeaseExtension ::findOrFail($this -> extensionId);
        $variationSum = $this -> leaseLiabilityOpeningBalance;
        $lastFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($this -> lease, $leaseExtension -> extension_start_date);

        $depreciationOpeningBalance = ($variationSum + $lastFlow -> depreciation_closing_balance - $lastFlow -> liability_closing_balance);
        return $depreciationOpeningBalance;
    }

    public function getLeaseFlows()
    {
        $leaseFlows = LeaseFlowService ::leaseFlowsNoDepreciation($this -> lease, $this -> extensionId);

        return $leaseFlows;
    }

    function updateLeaseFlows()
    {
        // TODO: Implement updateLeaseFlows() method.
    }
}