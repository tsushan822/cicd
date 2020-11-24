<?php

namespace App\Http\Controllers\System;


use App\Zen\System\Model\CustomPlan;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Spark\Contracts\Http\Requests\Settings\Teams\Subscription\CreateSubscriptionRequest;
use Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod\UpdatePaymentMethod;
use Laravel\Spark\Contracts\Interactions\SubscribeTeam;
use Laravel\Spark\Events\Teams\Subscription\SubscriptionUpdated;
use Laravel\Spark\Http\Controllers\Settings\Teams\Subscription\PlanController;
use Laravel\Spark\Spark;
use Laravel\Spark\Team;
use Stripe\Plan;
use Stripe\Stripe;

class CustomPlanController extends PlanController
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function customStore(Request $request, $team)
    {
        if(!$request->stripe_payment_method) {

            //Lets first check if exact same plan is available, if exists use it and replicate new db custom plan row with new team id
           /*$existingPlan = $this->checkIfSimilarPlanExists($request);
            if($existingPlan instanceof CustomPlan) {
                $newPlan = $existingPlan->replicate(['team_id' => request()->input('team_id')]);
                $team = $this->updateTeam(request()->input('team_id'), $newPlan->plan_id);
                event(new SubscriptionUpdated($team));
                return $newPlan;
            }*/

            //If it doesnt exist, create a new plan in stripe and create a row in db
            $plan = Plan::create([
                    "amount" => number_format(($request->amount * 100), 0, '', ''),
                    "interval" => $request->interval,
                    "currency" => config('cashier.currency'),
                    'trial_period_days' => config('cashier.trial_days'),
                    "product" => config('cashier.default_product_id') //dont change this
                ]
            );

            $createPlanAttr = [
                'plan_id' => $plan->id,
                'product_id' => config('cashier.default_product_id'),
                'amount' => $plan->amount,
                'trial_days' => config('cashier.trial_days'),
                'period' => $plan->interval,
                'fx_rate' => request()->input('fx_rate'),
                'plan_name' => request()->input('plan_name'),
                'services' => $this->serviceArrayFixer(request()->input('services')),
                'add_ons' => $this->addOnsArrayFixer(request()->input('add_ons')),
                'team_id' => request()->input('team_id'),
                'number_of_leases' => request()->input('number_of_leases'),
                'number_of_users' => request()->input('number_of_users'),
                'number_of_companies' => request()->input('number_of_companies'),
            ];
            $dbPlan = CustomPlan::create($createPlanAttr);
            $team = $this->updateTeam(request()->input('team_id'), $dbPlan->plan_id);
            event(new SubscriptionUpdated($team));
            //$this->swapPlans($plan -> id,$team->subscriptions()->first());
            return $dbPlan;
        }

    }

    public function getActivePlan(Request $request, $team)
    {

        return CustomPlan::where([
                ['plan_id', '=', $request->input('plan_id')],
                ['team_id', '=', $team->id]
            ]

        )->first();
    }

    public function store(CreateSubscriptionRequest $request, Team $team)
    {
        try {
            if($request->stripe_payment_method) {
                Spark::interact(UpdatePaymentMethod::class, [
                    $team, $request->all(),
                ]);
            }

            Spark::interact(SubscribeTeam::class, [
                $team, $request->plan(), false, $request->all()
            ]);
        } catch (IncompletePayment $e) {
            return response()->json([
                'paymentId' => $e->payment->id
            ], 400);
        }
    }

    public function getInitialPackage()
    {
        $subscription = config('zenlease.subscription');

       /* //getting the subscription information of a customer
        $team = \App\Zen\System\Model\Team::first();
        $customPlan = CustomPlan::where('plan_id', $team->current_billing_plan)->first();

        //setting customer's add_ons and services
        if( json_decode( $customPlan->services) !=[]){
            $subscription['custom_services']=json_decode( $customPlan->services);
        }
        if( json_decode( $customPlan->add_ons) !=[]){
            $subscription['add_ons']=json_decode( $customPlan->add_ons);
        }*/

        return $subscription;
    }

    public function checkIfSimilarPlanExists(Request $request)
    {
        $attr = [
            'amount' => number_format(($request->amount * 100), 0, '', ''),
            'trial_days' => config('cashier.trial_days'),
            'period' => $request->input('interval'),
            'plan_name' => $request->input('plan_name'),
            'services' => $request->input('services'),
            'add_ons' => $request->input('add_ons'),
            'number_of_leases' => $request->input('number_of_leases'),
            'number_of_users' => $request->input('number_of_users'),
            'number_of_companies' => $request->input('number_of_companies'),
        ];
        return CustomPlan::where($attr)->first();
    }

    public function updateTeam($team, $planId)
    {
        $team = Team::findOrFail($team);
        $team->current_billing_plan = $planId;
        $team->subscription()->stripe_plan = $planId;
        $team->save();
        $team->subscription()->save();
        return $team;
    }

    private function addOnsArrayFixer($addOns)
    {
        $addOnsName=collect(json_decode($addOns))->map(function($add_on){
            return $add_on->name;
        })->flatten()->toArray();
        $allAddOns=config('zenlease.subscription.add_ons');
        foreach($allAddOns as &$addOn){
            $key=array_search($addOn['name'],$addOnsName);
            if(false !==$key){
                $addOn['checked']=true;
            }
        }
        return json_encode($allAddOns);
    }
    private function serviceArrayFixer($service)
    {
        $serviceName=collect(json_decode($service))->map(function($service){
            return $service->name;
        })->flatten()->toArray();

        $allServices=config('zenlease.subscription.custom_services');

        foreach($allServices as &$service){
            $key=array_search($service['name'],$serviceName);
            if(false !==$key){
                $service['checked']=true;
            }
        }
        return json_encode($allServices);
    }

}