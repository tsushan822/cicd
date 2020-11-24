<?php


namespace App\Zen\Lease\Observer;


use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;

class LeaseExtensionObserver
{
    /**
     * Listen to the User created event.
     * @param LeaseExtension $leaseExtension
     * @return void
     */
    public function created(LeaseExtension $leaseExtension)
    {
        if($leaseExtension -> extension_start_date != $leaseExtension -> lease -> effective_date) {
            $lease = $leaseExtension -> lease;
            $lease -> exercise_price = $leaseExtension -> extension_exercise_price;
            $lease -> residual_value_guarantee = $leaseExtension -> extension_residual_value_guarantee;
            $lease -> penalties_for_terminating = $leaseExtension -> extension_penalties_for_terminating;
            $lease -> save();
        }
    }
}