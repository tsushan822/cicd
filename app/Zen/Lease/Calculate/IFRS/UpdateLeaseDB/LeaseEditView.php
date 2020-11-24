<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 04/05/2018
 * Time: 10.46
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB;

use App\Zen\Lease\Calculate\IFRS\LeaseDiscount;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;

class LeaseEditView extends LeaseEdited
{

    protected $leaseLiabilityOpeningBalance;
    protected $leaseFlows;

    /**
     * ExtensionLeaseEditView constructor.
     * @param Lease $lease
     */
    public function __construct(Lease $lease)
    {
        parent ::__construct($lease);
        $this -> leaseLiabilityOpeningBalance = LeaseFlowService ::leaseLiabilityOpeningBalance($lease);
        $this -> leaseFlows = LeaseFlow ::where('lease_id', $this -> lease -> id) -> get();
    }

    public function updateDepreciation()
    {

        $depreciationOpeningBalance = $this -> calculateAmountOfDepreciation();

        if(!count($this -> leaseFlows))
            return;

        $this -> amountOfDepreciation($this -> lease, $depreciationOpeningBalance);
    }

    public function updateLiability()
    {
        $this -> updateLeaseLiability($this -> leaseFlows, $this -> leaseLiabilityOpeningBalance);

    }

    function calculateAmountOfDepreciation()
    {
        $leaseExtensions = LeaseExtensionService ::allExtensions($this -> lease);
        if(count($leaseExtensions) > 1) {
            return 0;
        }

        $leaseLiabilityOpeningBalance = LeaseFlowService ::leaseLiabilityOpeningBalance($this -> lease);
        $depreciationOpeningBalance = $leaseLiabilityOpeningBalance + $this -> lease -> payment_before_commencement_date +
            $this -> lease -> initial_direct_cost + $this -> lease -> cost_dismantling_restoring_asset - $this -> lease -> lease_incentives_received;
        return $depreciationOpeningBalance;
    }

    public function getLeaseFlows()
    {
        return $this -> leaseFlows;
    }

    function updateLeaseFlows()
    {
        // TODO: Implement updateLeaseFlows() method.
    }

    public function updateVariationAmount()
    {
        $i = 1;
        if($this -> lease -> lease_flow_per_year == 12 && $this -> lease -> leaseType -> payment_type == 'Advance' && $this -> lease -> leaseType -> exclude_first_payment)
            $i = 0;
        $leaseFlows = LeaseFlow ::where('lease_id', $this -> lease -> id) -> get();
        foreach($leaseFlows as $leaseFlow) {
            $attr['fixed_amount'] = $leaseFlow -> fixed_payment;
            $attr['start_date'] = $leaseFlow -> leaseExtension -> date_of_change;
            $attr['end_date'] = $leaseFlow -> end_date;
            $leaseFlow -> variations = (new LeaseDiscount($this->lease)) -> calculateValue($leaseFlow -> leaseExtension -> lease_extension_rate, $attr, $i++, $this -> lease -> lease_flow_per_year);
            $leaseFlow -> save();
        }
    }
}