<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 11/02/2019
 * Time: 14.46
 */

namespace App\Zen\Lease\Event;


use App\Zen\Lease\Model\LeaseExtension;

trait DeleteLeaseExtension
{
    protected static function bootDeleteLeaseExtension()
    {
        static ::deleted(function ($model) {
            $lease = $model -> lease;
            $lastExtension = LeaseExtension ::where('lease_id', $lease -> id) -> orderBy('created_at','desc') -> first();
            if($model -> extension_end_date != null && $lastExtension instanceof LeaseExtension) {
                $model -> lease -> maturity_date = $lastExtension -> extension_end_date;
                $model -> lease -> lease_rate = $lastExtension -> lease_extension_rate;
                $model -> lease -> lease_amount = $lastExtension -> extension_period_amount;
                $model -> lease -> lease_service_cost = $lastExtension -> extension_service_cost;
                $model -> lease -> total_lease = $lastExtension -> extension_total_cost;
                $model -> lease -> exercise_price = $lastExtension -> extension_exercise_price;
                $model -> lease -> residual_value_guarantee = $lastExtension -> extension_residual_value_guarantee;
                $model -> lease -> penalties_for_terminating = $lastExtension -> extension_penalties_for_terminating;
                $model -> lease -> save();
            }
        });
    }
}