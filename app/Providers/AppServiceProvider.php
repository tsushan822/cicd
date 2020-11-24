<?php

namespace App\Providers;

use App\Zen\Setting\Model\AdminSetting;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Observers\CounterpartyObserver;
use App\Zen\System\Model\Customer;
use App\Zen\System\Observer\CustomerObserver;
use App\Zen\System\Service\ModuleAvailabilityService;
use App\Zen\User\Model\User;
use App\Zen\User\Observer\UserObserver;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Facades\TenancyFacade;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        $this->getPayloadUsing();

        $this->assignTesting();

        $this->jobProcessing();

        $website = TenancyFacade::website();

        if ($website instanceof Website) {

            $this->assignFqdn();

            $this->counterpartyObserver();

            $this->importFolder($website);

            $this->assignWebsiteId($website);

            $this->assignReportLibraryTab();

        }

        $this->customerObserver();
        $this->userObserver();
        $this->adminSettingCostCenterSplit();

    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
    }

    public function assignFqdn(): void
    {
        config(['database.default' => 'tenant']);
    }

    public function jobProcessing(): void
    {
        $this->app['events']->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload()['user_email'])) {
                config(['queue_user_email' => $event->job->payload()['user_email']]);
            }
        });
    }

    public function getPayloadUsing(): void
    {
        $this->app['queue']->createPayloadUsing(function () {
            return auth()->check() ? [
                'user_email' => auth()->user()->email
            ] : [];
        });
    }

    private function assignTesting()
    {
        if ($this->app->environment() == 'testing') {
            $environment = $this->app->make(Environment::class);
            $hostName = Hostname::where('fqdn', env('DUSK_TESTING_URL'))->first();
            $website = Website::where('id', $hostName->website_id)->first();
            $environment->tenant($website);
            $this->assignWebsiteId($website);
        }

    }

    public function adminSettingCostCenterSplit()
    {
        $this->app->singleton('costCenterSplitAdmin', function () {
            $costCenterSplit = false;

            $adminSetting = AdminSetting::first();

            if ($adminSetting instanceof AdminSetting && $adminSetting->enable_cost_center_split) {
                $costCenterSplit = true;
            }

            return $costCenterSplit;
        });
    }

    public function counterpartyObserver()
    {
        Counterparty::observe(CounterpartyObserver::class);
    }

    private function assignLocale()
    {
        if (auth()->check())
            $this->app->setLocale(auth()->user()->locale);
    }

    /**
     * @param Website $website
     * @return void
     */
    private function importFolder(Website $website)
    {
        config(['filesystems.disks.google_la_customer.path_prefix' => 'Customer' . DIRECTORY_SEPARATOR . $website->uuid]);
    }

    public function assignWebsiteId($website)
    {
        config(['website_id' => $website->id]);
        $this->app->singleton('websiteId', function () use ($website) {
            return $website->id;
        });
    }

    private function customerObserver()
    {
        Customer::observe(CustomerObserver::class);
    }

    private function assignReportLibraryTab()
    {
        if (!$this->app->runningInConsole()) {
            $this->app->singleton('reportLibraryAvailability', function () {
                return ModuleAvailabilityService::checkReportLibraryAvailability();
            });
        }
    }

    private function userObserver()
    {
        User::observe(UserObserver::class);
    }
}
