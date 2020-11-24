<?php

namespace App\Providers;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Observer\LeaseExtensionObserver;
use App\Zen\Lease\Observer\LeaseObserver;
use App\Zen\Lease\Service\LeaseAccruedInterest;
use Illuminate\Support\ServiceProvider;

class LeaseModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Lease::observe(LeaseObserver::class);

        LeaseExtension::observe(LeaseExtensionObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('leaseAccruedInterest', function () {
            return new LeaseAccruedInterest;
        });
    }
}
