<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/05/2018
 * Time: 11.37
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Setting\Calculate\DateTime\Traits\PaymentDayCalculation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UpdateDepreciationValues
{
    use PaymentDayCalculation;
    /**
     * @var Lease
     */
    private $lease;

    /**
     * UpdateDepreciationValues constructor.
     * @param Lease $lease
     */
    public function __construct(Lease $lease)
    {
        $this -> lease = $lease;
    }

    public function updateDepreciation($depreciationOpeningBalance)
    {
        $leaseExtension = LeaseExtensionService ::lastExtension($this -> lease);
        $leaseFlows = LeaseFlowService ::leaseFlowsAll($this -> lease, $leaseExtension -> id);

        if(!$leaseExtension instanceof LeaseExtension) {
            return;
        } elseif(count($this -> lease -> leaseExtension) == 1) {
            $depreciationPerMonth = LeaseFlowService ::startEndDate($this -> lease, $depreciationOpeningBalance);
        } else {
            $firstLeaseFlow = LeaseFlowService ::firstLeaseFlowNoDepreciation($this -> lease, $leaseExtension -> id);
            if(!$depreciationOpeningBalance) {
                $depreciationOpeningBalance = $firstLeaseFlow -> depreciation_opening_balance;
            }
            $depreciationPerMonth = LeaseFlowService ::startEndDateBesideExtension($this -> lease, $depreciationOpeningBalance, $leaseExtension);
        }

        //Add monthly depreciation to extension
        $leaseExtension -> monthly_depreciation = $depreciationPerMonth;
        $leaseExtension -> save();

        $this -> equalDepreciationPayment($depreciationOpeningBalance, $depreciationPerMonth, $leaseFlows);


        /*if($numberOfDepreciation < count($leaseFlows)) {
            $this -> lessDepreciationPayment($depreciationOpeningAmount, $depreciationPerMonth, $leaseFlows, $numberOfDepreciation);
        }

        if($numberOfDepreciation > count($leaseFlows)) {
            $this -> moreDepreciationPayment($depreciationOpeningAmount, $depreciationPerMonth, $leaseFlows, $numberOfDepreciation, $leaseExtension);
        }

        //Delete all other depreciation if term is reduced
        $deleteAllEmptyDepreciation = LeaseFlowService ::deleteAllEmptyDepreciation($this -> lease);*/
    }

    /*public function lessDepreciationPayment($depreciationOpeningAmount, $depreciation, $leaseFlows, $numberOfDepreciation)
    {
        for($i = 0; $i < $numberOfDepreciation; $i++) {
            $depreciationAmount = LeaseFlowService ::depreciationAmount($leaseFlows[$i], $depreciation);
            //For depreciation
            $leaseFlows[$i] -> depreciation_opening_balance = $depreciationOpeningAmount;
            $leaseFlows[$i] -> depreciation = $depreciationAmount;
            $depreciationClosingAmount = $depreciationOpeningAmount - $depreciationAmount;
            $leaseFlows[$i] -> depreciation_closing_balance = $depreciationClosingAmount;
            $depreciationOpeningAmount = $depreciationClosingAmount;
            $leaseFlows[$i] -> save();
        }
    }*/

    public function equalDepreciationPayment($depreciationOpeningAmount, $depreciation, $leaseFlows)
    {
        foreach($leaseFlows as $leaseFlow) {
            $depreciationAmount = LeaseFlowService ::depreciationAmount($leaseFlow, $depreciation);
            //For depreciation
            $leaseFlow -> depreciation_opening_balance = $depreciationOpeningAmount;
            $leaseFlow -> depreciation = $depreciationAmount;
            $depreciationClosingAmount = $depreciationOpeningAmount - $depreciationAmount;
            $leaseFlow -> depreciation_closing_balance = $depreciationClosingAmount;
            $depreciationOpeningAmount = $depreciationClosingAmount;
            $leaseFlow -> save();
        }
    }

    /*public function moreDepreciationPayment($depreciationOpeningAmount, $depreciation, $leaseFlows, $numberOfDepreciation, $leaseExtension)
    {
        $depreciationStart = $leaseFlows[count($leaseFlows) - 1] -> end_date;
        for($i = 0; $i < $numberOfDepreciation; $i++) {
            $depreciationAmount = LeaseFlowService ::depreciationAmount($leaseFlows[$i], $depreciation);
            if($i < count($leaseFlows)) {
                //For depreciation
                $leaseFlows[$i] -> depreciation_opening_balance = $depreciationOpeningAmount;
                $leaseFlows[$i] -> depreciation = $depreciationAmount;
                $depreciationClosingAmount = $depreciationOpeningAmount - $depreciationAmount;
                $leaseFlows[$i] -> depreciation_closing_balance = $depreciationClosingAmount;
                $depreciationOpeningAmount = $depreciationClosingAmount;
                $leaseFlows[$i] -> save();
            } else {
                $leaseFlow = new LeaseFlow();
                $leaseFlow -> start_date = $depreciationStart;
                $depreciationEnd = Carbon ::parse($depreciationStart) -> addMonthsNoOverflow(12 / $this -> lease -> lease_flow_per_year) -> endOfMonth() -> toDateString();
                $leaseFlow -> end_date = $depreciationEnd;
                $leaseFlow -> payment_date = self :: paymentDayCalculation($depreciationEnd, $this -> lease -> payment_day);
                $leaseFlow -> depreciation_opening_balance = $depreciationOpeningAmount;
                $leaseFlow -> depreciation = $depreciationAmount;
                $depreciationClosingAmount = $depreciationOpeningAmount - $depreciationAmount;
                $leaseFlow -> depreciation_closing_balance = $depreciationClosingAmount;
                $depreciationOpeningAmount = $depreciationClosingAmount;
                $leaseFlow -> lease_id = $this -> lease -> id;
                $leaseFlow -> lease_extension_id = $leaseExtension -> id;
                $leaseFlow -> user_id = Auth ::check() ? Auth ::id() : null;
                $leaseFlow -> save();
                $depreciationStart = $depreciationEnd;
            }
        }
    }*/
}