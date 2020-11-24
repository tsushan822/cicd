<?php

namespace App\Providers;

use App\Zen\User\Model\Permission;
use Hyn\Tenancy\Models\Website;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot()
    {
        if(app() -> runningInConsole()) {
            echo 'Running in console (i.e. migration).  Disabling AuthServiceProvider' . PHP_EOL;
            return;
        }

        $website = \Hyn\Tenancy\Facades\TenancyFacade ::website();
        if($website instanceof Website) {
            $this -> registerPolicies();
            foreach($this -> getPermissions() as $permission) {
                Gate ::define($permission -> name, function ($user) use ($permission) {
                    return $user -> hasRole($permission -> roles);
                });
            }
        }
    }

    /**
     * Fetch the collection of site permissions.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return Permission ::with('roles') -> get();
    }
}
