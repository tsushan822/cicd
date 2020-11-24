<?php

namespace App\Console\Commands\Settings\Rates;

use App\Jobs\Settings\UpdateFxRateJob;
use App\Zen\System\Model\Customer;
use Illuminate\Console\Command;

class UpdateTenantFxRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:fx-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the fx rate for each tenant';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent ::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $tenants = Customer ::with('website') -> whereNotNull('fx_rate_source') -> whereNull('databond_client_id') -> where('databond_rate_import', '<>', 1) -> active() -> get();
        foreach($tenants as $tenant) {
            UpdateFxRateJob ::dispatch($tenant -> website_id, true);
        }


        $dataBondTenants = Customer ::with('website') -> where('fx_rate_source', 'databond') -> where('databond_rate_import', 1) -> active() -> get();
        foreach($dataBondTenants as $tenant) {
            UpdateFxRateJob :: dispatch($tenant -> website_id);
        }
    }
}
