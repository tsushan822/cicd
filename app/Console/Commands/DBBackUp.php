<?php

namespace App\Console\Commands;

use App\Jobs\Settings\DatabaseBackupJob;
use App\Jobs\Settings\UpdateFxRateJob;
use App\Zen\System\Model\BackUp;
use App\Zen\System\Model\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DBBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:all:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backups all the database';

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
        $customerIds = BackUp ::where('always_backup', 1) -> orWhere(function ($query) {
            $query -> where('always_backup', 0) -> where('backup_days', '<>', 0);
        }) -> pluck('customer_id');
        $tenants = Customer ::with('website') -> whereIn('id', $customerIds) -> active() -> get();
        foreach($tenants as $tenant) {
            DatabaseBackupJob ::dispatch($tenant -> website_id);
        }

        config(['backup.backup.source.databases' => ['system']]);
        $fileName = strtolower(today() -> dayName) . '_system_db.zip';
        $exists = Storage ::disk('google') -> exists('Backups/' . $fileName);
        if($exists) {
            Storage ::disk('google') -> delete('Backups/' . $fileName);
        }
        Artisan ::call('backup:run', ['--only-db' => 1, '--filename' => $fileName]);
    }
}
