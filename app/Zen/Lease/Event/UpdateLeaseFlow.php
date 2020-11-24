<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 29/08/2018
 * Time: 15.03
 */

namespace App\Zen\Lease\Event;


use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\LeaseEditView;
use App\Zen\Lease\Service\LeaseFlowService;

trait UpdateLeaseFlow
{
    protected static function bootUpdateLeaseFlow()
    {
        static ::updated(function ($model) {
            if($model -> isDirty('fixed_payment') && $model -> lease -> ifrs_accounting) {
                (new LeaseEditView($model -> lease)) -> updateVariationAmount();
                (new LeaseEditView($model -> lease)) -> updateDepreciation();
                (new LeaseEditView($model -> lease)) -> updateLiability();
                LeaseFlowService ::updateRepayment($model -> lease_id);
                LeaseFlowService ::updateShortLiabilityWithLease($model -> lease);
            }
            return true;
        });
    }
}