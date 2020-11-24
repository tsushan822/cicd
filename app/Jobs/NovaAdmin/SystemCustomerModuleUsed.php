<?php

namespace App\Jobs\NovaAdmin;

use App\Zen\System\Model\Customer;
use App\Zen\Lease\Model\Lease;
use App\Zen\System\Model\Module;
use App\Zen\System\Model\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Laravel\Spark\TeamSubscription;

class SystemCustomerModuleUsed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $website_id;

    /**
     * Create a new job instance.
     *
     * @param int $websiteId
     */
    public function __construct(int $website_id)
    {
        $this->website_id = $website_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer= Customer::where('website_id', $this->website_id)->first();
        $leaseCount= Lease::all()->count();
        $module=Module::where('customer_id', '=', $customer->id)->firstOrFail();
        $module->module_usage=$leaseCount;
        if(TeamSubscription::all()->count()>0){
            $module->plan_type='Subscribed';
        }
        else if(Team::first()->trial_ends_at>now()){
            $module->plan_type='Trial';
        }
        else {
            $module->plan_type='Trial-ended';
        }

        $module->save();

    }


}
