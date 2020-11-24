<?php

namespace App\Console\Commands;
use App\Jobs\NovaAdmin\SystemCustomerModuleUsed;
use App\Zen\System\Model\Customer;
use Illuminate\Console\Command;

class CustomerModuleUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Customer:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the system database with the number of contracts used by a client';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $tenants = Customer ::with('website') -> active() -> get();
        foreach($tenants as $tenant) {
            SystemCustomerModuleUsed ::dispatch($tenant -> website_id);
        }
    }
}
