<?php

namespace App\Console\Commands;

use App\Jobs\Settings\MaturingDealCommandJob;
use App\Zen\System\Model\Customer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MaturingDealNotifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'maturing:notify {database?}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Notify users about maturing deals';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent ::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $tenants = Customer :: with('website')->active() -> get();

        foreach($tenants as $tenant) {
            dispatch((new MaturingDealCommandJob($tenant -> website_id)));
        }
        //AdminNotify ::send(new CommandExecuted($this -> getTask()));
        return;
    }

    public function getTask()
    {
        return (object)[
            'title' => 'Email maturing command',
            'description' => 'Email maturing command has been executed on ' . Carbon ::now() -> toDateTimeString(),
        ];
    }
}
