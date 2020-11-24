<?php

namespace App\Providers;

use App\Zen\System\Model\CustomPlan;
use App\Zen\System\Model\Team;
use Hyn\Tenancy\Facades\TenancyFacade;
use Hyn\Tenancy\Models\Website;
use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'LeaseAccounting App',
        'product' => 'Lease accounting app',
        'street' => 'Otakaari 5',
        'location' => '02150 Espoo, Finland',
        'phone' => '+358 9 424 68300',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'support@zentreasury.com';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'info@zentreasury.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {

        $this -> currentActivePlan();

        Spark ::noAdditionalTeams();

        Spark ::collectBillingAddress();

        Spark ::collectEuropeanVat('FI');

        Spark ::promotion('coupon-code');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public
    function register()
    {
        parent ::register();
    }


    private
    function currentActivePlan(): void
    {

        if(!$this -> app -> runningInConsole()) {
            $website = TenancyFacade ::website();
            if(!$website instanceof Website) {
                //monthly plans

                Spark ::teamPlan('Basic', config('zenlease.stripe.plan_id.' . env('SERVER_LEVEL') . '.basic-monthly'))
                    -> trialDays(30)
                    -> price(199)
                    -> features(['Two Team Members', 'Upto 20 leases']);

                Spark ::teamPlan('Professional', config('zenlease.stripe.plan_id.' . env('SERVER_LEVEL') . '.professional-monthly'))
                    -> trialDays(30)
                    -> price(399)
                    -> features(['Five Team Members', 'Upto 50 leases']);

                Spark ::teamPlan('Business', config('zenlease.stripe.plan_id.' . env('SERVER_LEVEL') . '.business-monthly'))
                    -> price(699)
                    -> trialDays(30)
                    -> features(['10 Team Members', 'Upto 400 leases']);
                //yearly plans

                Spark ::teamPlan('Basic', config('zenlease.stripe.plan_id.' . env('SERVER_LEVEL') . '.basic-yearly'))
                    -> price(1990)
                    -> trialDays(30)
                    -> yearly()
                    -> features(['Two Team Members', 'Upto 20 leases']);

                Spark ::teamPlan('Professional', config('zenlease.stripe.plan_id.' . env('SERVER_LEVEL') . '.professional-yearly'))
                    -> price(3990)
                    -> trialDays(30)
                    -> yearly()
                    -> features(['Five Team Members', 'Upto 50 leases']);

                Spark ::teamPlan('Business', config('zenlease.stripe.plan_id.' . env('SERVER_LEVEL') . '.business-yearly'))
                    -> price(6990)
                    -> trialDays(30)
                    -> yearly()
                    -> features(['10 Team Members', 'Upto 400 leases']);

            } else {
                $team = Team ::first();
                $customPlan = CustomPlan ::where('team_id', $team -> id) -> orderBy('id', 'desc') -> get();
                //We need to use this code below to make the view work!
                Spark ::teamPlan('team-is-on-trial', 'team-is-on-trial')
                    -> price(30)
                    -> features(['Five Team Members', 'Five companies', 'Upto 10 leases', 'Multicurrency']);

                foreach($customPlan as $customPlanOfTeam) {
                    Spark ::teamPlan($customPlanOfTeam -> plan_name, $customPlanOfTeam -> plan_id)
                        -> price(250)
                        -> features(['Ten Team Members', 'Ten companies', 'Upto 500 leases', 'Multicurrency', 'Attachments', 'Audit trial', 'Fx-rate', 'Backup weekly', 'Dedicated support']);

                }
            }
        }
    }
}
