<?php

namespace Laravel\Spark\Listeners\Teams\Subscription;

use App\Zen\System\Model\Customer;
use App\Zen\System\Model\Module;
use Laravel\Spark\Events\Teams\Subscription\SubscriptionCancelled;

class UpdateActiveSubscription
{
    /**
     * Handle the event.
     *
     * @param mixed $event
     * @return void
     */
    public function handle($event)
    {
        $currentPlan = $event instanceof SubscriptionCancelled
            ? null : $event -> team -> subscription() -> provider_plan;

        $event -> team -> forceFill([
            'current_billing_plan' => $currentPlan,
        ]) -> save();

        $teamId = $event -> team -> id;
        $customer = Customer ::where('team_id', $teamId) -> first();
        $module = Module ::where('customer_id', $customer -> id) -> where('name', 'Lease') -> first();

        switch($currentPlan){
            case null:
                $module -> available_number = 10;
                break;
            case 'provider-id-1':
                $module -> available_number = 100;
                break;
            case 'provider-id-2':
                $module -> available_number = 200;
                break;
            case 'provider-id-3':
                $module -> available_number = 300;
                break;
            case 'provider-id-4':
                $module -> available_number = 400;
                break;
            case 'plan_HEeOMA3G9tQ28a':
                $module -> available_number = 500;
                break;
        }
        $module->plan_type = $currentPlan;
        $module -> save();
    }
}
