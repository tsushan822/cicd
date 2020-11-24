<?php

namespace App\Listeners\System;

use App\Zen\System\Model\Customer;
use App\Zen\System\Model\CustomPlan;
use App\Zen\System\Model\Module;
use Laravel\Spark\Events\Teams\Subscription\SubscriptionCancelled;

class UpdateTeamSubscription
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
        if(!$currentPlan) {
            return;
        }


        $teamId = $event -> team -> id;

        $customer = Customer ::where('team_id', $teamId) -> first();
        $moduleLease = Module ::where('customer_id', $customer -> id) -> where('name', 'Lease') -> first();
        $moduleUser = Module ::where('customer_id', $customer -> id) -> where('name', 'User') -> first();
        $moduleCompany = Module ::where('customer_id', $customer -> id) -> where('name', 'Company') -> first();

        $packageType = CustomPlan ::where('plan_id', '=', $currentPlan) -> where('team_id', $teamId) -> first();

        switch($packageType -> plan_name){
            case null:
                $moduleLease -> available_number = 10;
                $moduleUser -> available_number = 2;
                $moduleCompany -> available_number = 5;
                break;

            case 'Basic':
                $moduleLease -> available_number = config('zenlease.subscription.plan')[0]['initial_lease'] + $packageType -> number_of_leases;
                $moduleUser -> available_number = config('zenlease.initial_user_number.basic');
                $moduleCompany -> available_number = config('zenlease.initial_company_number.basic');
                break;

            case 'Professional':
                $moduleLease -> available_number = config('zenlease.subscription.plan')[1]['initial_lease'] + $packageType -> number_of_leases;
                $moduleUser -> available_number = config('zenlease.initial_user_number.professional');
                $moduleCompany -> available_number = config('zenlease.initial_company_number.professional');
                break;

            case 'Business':
                $moduleLease -> available_number = config('zenlease.subscription.plan')[2]['initial_lease'] + $packageType -> number_of_leases;
                $moduleUser -> available_number = config('zenlease.initial_user_number.enterprise');
                $moduleCompany -> available_number = config('zenlease.initial_company_number.enterprise');
                break;

        }

        $moduleLease -> plan_type = $packageType -> plan_name;
        $moduleUser -> plan_type = $packageType -> plan_name;
        $moduleCompany -> plan_type = $packageType -> plan_name;
        $moduleLease -> save();
        $moduleUser -> save();
        $moduleCompany -> save();

        //Handling the add ons
        if($packageType -> add_ons)
            $this -> handleAddOns($packageType, $customer);
    }

    /**
     * @param $packageType
     * @param $customer
     */
    private function handleAddOns(CustomPlan $packageType, Customer $customer): void
    {
        $addOns = json_decode($packageType -> add_ons);
        foreach($addOns as $addOn) {
            if($addOn -> name == 'Central bank Fx Rates') {
                $customer -> databond_rate_import = $addOn -> checked == true;
                $customer -> fx_rate_source = $addOn -> checked == true ? 'databond' : null;
                $customer -> save();
            }

            if($addOn -> name == 'Backups') {
                $customer -> backUp -> always_backup = $addOn -> checked == true;
                $customer -> backUp -> save();
            }

        }
    }
}
