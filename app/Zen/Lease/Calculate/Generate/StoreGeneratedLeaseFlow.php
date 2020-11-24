<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/04/2018
 * Time: 15.14
 */

namespace App\Zen\Lease\Calculate\Generate;

use App\Scopes\LeaseAccountableScope;
use App\Zen\Lease\Calculate\IFRS\LeaseDiscount;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEditView;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use Illuminate\Support\Facades\Auth;

class StoreGeneratedLeaseFlow extends LeaseEditView
{

    public function storeGeneratedLeaseFlow($request)
    {
        $paymentsTime = unserialize($request -> payments_time);
        $leasePaymentAmount = $request -> lease_payment;
        $leaseServiceAmount = $request -> fees;
        $calcStartDate = $request -> calc_start_date;

        $leaseId = $this -> storeLeaseFlows($paymentsTime, $leasePaymentAmount, $leaseServiceAmount, $calcStartDate);
        return $leaseId;
    }

    public function storeLeaseFlows($paymentsTime, $leasePaymentAmount, $leaseServiceAmount, $calcStartDate)
    {
        $leaseFlows = LeaseFlowService ::leaseFlowsNoDepreciation($this -> lease);
        $i = 1;
        if($this -> lease -> lease_flow_per_year == 12 && $this -> lease -> leaseType -> payment_type == 'Advance' && $this -> lease -> leaseType -> exclude_first_payment)
            $i = 0;

        $leaseExtension = new LeaseExtension();
        $leaseExtension -> lease_id = $this -> lease -> id;
        $leaseExtension -> date_of_change = $calcStartDate;
        $leaseExtension -> extension_start_date = $calcStartDate;
        $leaseExtension -> extension_period_amount = $leasePaymentAmount;
        $leaseExtension -> extension_service_cost = $leaseServiceAmount;
        $leaseExtension -> extension_total_cost = $leasePaymentAmount + $leaseServiceAmount;
        $leaseExtension -> lease_extension_rate = $this -> lease -> lease_rate;
        $leaseExtension -> user_id = Auth ::id();
        $leaseExtension -> save();

        if(count($leaseFlows)) {
            $this -> updateVariationAmount();
        }
        foreach($paymentsTime as $paymentTime) {
            $attr = [
                'lease_id' => $this -> lease -> id,
                'user_id' => Auth ::id(),
                'account_id' => $this -> lease -> account_id,
                'payment_date' => $paymentTime['payment_date'],
                'end_date' => $paymentTime['end_date'],
                'start_date' => $paymentTime['start_date'],
                'interest_start_date' => $leaseExtension -> date_of_change,
                'fixed_payment' => $paymentTime['fixed_amount'],
                'total_payment' => $paymentTime['fixed_amount'] + $paymentTime['fees'],
                'fees' => $paymentTime['fees'],
                'lease_extension_id' => $leaseExtension -> id,
            ];
            if($this -> lease -> ifrs_accounting) {
                $parameter['start_date'] = $leaseExtension -> date_of_change;
                $parameter['end_date'] = $paymentTime['end_date'];
                $parameter['fixed_amount'] = $paymentTime['fixed_amount'];
               $discountedInstrument = (new LeaseDiscount($this -> lease)) -> calculateValue($this -> lease -> lease_rate, $parameter, $i++, $this -> lease -> lease_flow_per_year);
                $attr['variations'] = $discountedInstrument;
            }
            $leaseFlow = LeaseFlow ::create($attr);
        }

        if(isset($paymentTime)) {
            $leaseExtension -> extension_end_date = $paymentTime['end_date'];
            LeaseExtensionService ::addComponentsAtFirstExtension($leaseExtension);
        }

        if($this -> lease -> ifrs_accounting) {
            (new LeaseEditView($this -> lease)) -> updateDepreciation();
            (new LeaseEditView($this -> lease)) -> updateLiability();
            LeaseFlowService ::updateRepayment($this -> lease -> id);
            LeaseFlowService ::updateShortLiabilityWithLease($this -> lease);
        }

        return $this -> lease -> id;
    }
}