<?php

namespace App\Console\Commands\Tenancy;

use App\Zen\System\Model\Customer;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteOldEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drop:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all environment that has expiry date crossed';

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
     * @return int
     */
    public function handle()
    {
        $username = env('DB_USERNAME');
        $host = env('DB_HOST');
        $password = env('DB_PASSWORD');

        $oneMonthEarlier = today() -> subDays(config('zenlease.expiry_if_not_subscribed')) -> toDateString();
        $customers = Customer ::whereNotNull('trial_ends_at') -> where('trial_ends_at', '<', $oneMonthEarlier)->active() -> get();
        foreach($customers as $customer) {
            try {
                $db = $customer -> database;
                // Create connection
                $conn = new \mysqli($host, $username, $password);
                $this -> info(json_encode($conn));
                // return $conn;
                // Check connection
                if($conn -> connect_error) {
                    die("Connection failed: " . $conn -> connect_error);
                }
                // Drop database
                $sqlUser = "DROP USER `$db`@%";
                $sqlDb = "DROP DATABASE `$db`";
                if($conn -> query($sqlUser) === TRUE) {
                    Log ::critical("Sucessfully dropped user $db!");
                } else {
                    Log ::critical("Error dropping user: " . $conn -> error);
                }
                if($conn -> query($sqlDb) === TRUE) {
                    Log ::critical("Sucessfully dropped database $db!");
                    $customer -> active_status = 0;
                    $customer -> save();
                    $affected = DB ::connection('system') -> table('users')
                        -> where('customer_id', $customer -> id)
                        -> update(['active_status' => 0]);

                    $affected = DB ::connection('system') -> table('hostnames')
                        -> where('website_id', $customer -> website_id)
                        -> delete();
                } else {
                    Log ::critical("Error dropping database: " . $conn -> error);
                }
                $conn -> close();
            } catch (Exception $e) {
                Log ::critical("Error dropping database: $db" . $e -> getMessage());
            }
        }

    }
}
