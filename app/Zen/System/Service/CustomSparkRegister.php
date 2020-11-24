<?php


namespace App\Zen\System\Service;


use App\Zen\System\Model\CustomPlan;
use Illuminate\Support\Facades\Log;
use Laravel\Spark\Interactions\Auth\Register;
use Stripe\Plan;
use Stripe\Stripe;

class CustomSparkRegister extends Register
{

    /**
     * CustomSparkRegister constructor.
     * @param $teamUser
     */
    public function __construct($teamUser)
    {
        self ::$team = $teamUser;
        Stripe ::setApiKey(env('STRIPE_SECRET'));
    }

    public function subscribe($request, $user)
    {
        $this -> createCustomPlan($request);

        $user = parent ::subscribe($request, $user);

        return $user;
    }

    private function createCustomPlan($request)
    {
        //Fill up data with request parameter, plan id and plan name

        //Here send plan id from the request and replace this
        $plan = Plan ::retrieve(
            $request -> plan,
            []
        );

        $createPlanAttr = [
            'plan_id' => $plan -> id,
            'product_id' => $plan -> product,
            'amount' => $plan -> amount,
            'trial_days' => config('cashier.trial_days'),
            'period' => $plan -> interval,
            'plan_name' => $request -> customPlanNameRegister,
            'services' => '',
            'add_ons' => '',
            'team_id' => self ::$team -> id,
        ];
        $dbPlan = CustomPlan ::create($createPlanAttr);
    }
}