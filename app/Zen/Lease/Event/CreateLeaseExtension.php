<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 09/05/2018
 * Time: 8.46
 */

namespace App\Zen\Lease\Event;


use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEditView;
use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\UpdateLeasePaymentDay;

trait CreateLeaseExtension
{

    protected static function bootCreateLeaseExtension()
    {
        static ::created(function ($model) {
            if($model -> extension_end_date != null) {
                $model -> lease -> maturity_date = $model -> extension_end_date;
                $model -> lease -> lease_rate = $model -> lease_extension_rate;
                $model -> lease -> lease_amount = $model -> extension_period_amount;
                $model -> lease -> lease_service_cost = $model -> extension_service_cost;
                $model -> lease -> total_lease = $model -> extension_total_cost;
                $model -> lease -> save();
            }
        });
    }
}