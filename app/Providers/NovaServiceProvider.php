<?php

namespace App\Providers;

use App\Nova\Metrics\SubscribedUsers;
use Coroowicaksono\ChartJsIntegration\PieChart;
use CustomSignUpCharts;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\NewCustomers;
use App\Nova\Metrics\TotalCustomers;
use Zenlease\ModuleUsage\ModuleUsage;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
                'lars@zentreasury.com',
                'prakash@zentreasury.com',
                'ville@zentreasury.com',
                'sakib@zentreasury.com'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new NewCustomers(),
            new TotalCustomers(),
            new SubscribedUsers(),
            (new CustomSignUpCharts())
                ->title('LeaseAccounting System')
                ->model('\App\Zen\System\Model\Module')
                ->series(array([
                    'label' => 'Ongoing trial period',
                    'filter' => [
                        'key' => 'modules.plan_type', // State Column for Count Calculation Here
                        'operator' => '=',
                        'value' => 'Trial',
                    ],
                ],
                    [
                        'label' => 'Trial ended',
                        'filter' => [
                            'key' => 'modules.plan_type', // State Column for Count Calculation Here
                            'operator' => '=',
                            'value' => 'Trial-ended',
                        ],
                    ],
                    [
                        'label' => 'Subscribed',
                        'filter' => [
                            'key' => 'modules.plan_type', // State Column for Count Calculation Here
                            'operator' => '=',
                            'value' => 'Subscribed',
                        ],
                    ],
                ))
                ->options([
                    'showTotal' => true,
                    'showPercentage' => true,
                    'btnFilter' => true,
                    'btnFilterDefault' => 'YTD',
                    'btnFilterList' => [
                        'YTD'   => 'Year to Date',
                        'QTD'   => 'Quarter to Date',
                        'MTD'   => 'Month to Date',
                        '30'   => '30 Days', // numeric key will be set to days
                        '28'   => '28 Days', // numeric key will be set to days
                    ],
                ])

                ->width('full')
            /*new CustomerByPlan(),
            new TotalRevenue(),
            new CustomersPerPlan(),*/
           // new \Llaski\NovaScheduledJobs\NovaScheduledJobsCard,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
          //  new \Llaski\NovaScheduledJobs\NovaScheduledJobsTool,
            new ModuleUsage()
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



}
