<?php

namespace App\Providers;

use App\Zen\System\Service\Cloudflare\Cloudflare;
use Illuminate\Support\ServiceProvider;

class CloudflareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $cloudflareConfig = config('cloudflare');

        $this->app->bind('cloudflare', function () use ($cloudflareConfig) {
            return new Cloudflare($cloudflareConfig['email'], $cloudflareConfig['key'], $cloudflareConfig['zone']);
        });
    }
}
