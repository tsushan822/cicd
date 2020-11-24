<?php

namespace App\Console\Commands\Tenancy;

use App\Jobs\System\CreateCustomerJob;
use App\Jobs\User\AddUserJob;
use App\Zen\Client\Service\CreateCustomer;
use App\Zen\System\Model\BackUp;
use App\Zen\System\Model\Customer;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add website for the customer';

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
        $customerData = [];
        $customerData['fqdn'] = $this -> ask('What is the name of the domain(Ex:- demo.zentreasury.app)?');
        $customerData['name'] = $this -> ask('What is the name of the customer(Ex:- Demo)?');
        $customerData['team_id'] = 1;
        $fxRateSource = $this -> ask('What is the fx rate source? Please type one of these or leave empty. (ecb-rate, riks-bank)');
        if((is_null($fxRateSource) ==false) && ($fxRateSource != config('fx-rate.sources'))) {
            $this -> warn('Please type rate source one of these:' . json_encode(config('fx-rate.sources')));
            return;
        }
        $customerData['fx_rate_source'] = $fxRateSource;

        CreateCustomerJob::dispatch($customerData);

        $this -> info('The website is created.');
        PHP_EOL;

        $this -> info('Running migration for "' . $customerData['name'] . '"');
        return;
    }
}