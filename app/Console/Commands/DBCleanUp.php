<?php

namespace App\Console\Commands;

use App\Jobs\Settings\DatabaseCleanUpJob;
use App\Zen\System\Model\Customer;
use Illuminate\Console\Command;

class DBCleanUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:all:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleaning the backup that is older';

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
        $tenants = Customer ::with('website') -> active() -> get();
        foreach($tenants as $tenant) {
            DatabaseCleanUpJob ::dispatch($tenant -> website_id);
        }
    }
}
