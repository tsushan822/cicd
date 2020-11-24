<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/05/2018
 * Time: 11.17
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB;

use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Setting\Calculate\DateTime\Traits\PaymentDayCalculation;

class UpdateLeasePaymentDay
{
    use PaymentDayCalculation;

    public static function updatePaymentDay($lease)
    {
        $leaseFlows = LeaseFlowService ::leaseFlowsAll($lease);
        foreach($leaseFlows as $leaseFlow) {
            $paymentDate = LeaseFlowService ::updatePaymentDay($leaseFlow -> payment_date, $lease);
            $leaseFlow -> payment_date = $paymentDate;
            $leaseFlow -> save();
        }
    }
}