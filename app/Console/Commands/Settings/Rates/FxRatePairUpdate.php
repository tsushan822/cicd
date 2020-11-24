<?php

namespace App\Console\Commands\Settings\Rates;

use App\Jobs\Settings\UpdateTenantPairJob;
use App\Zen\System\Model\Customer;
use App\Zen\User\UserList\AllUser;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notifiable;

class FxRatePairUpdate extends Command
{
    use Notifiable;
    use AllUser;
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'fxrate:pair';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Updating fx rate pair';


    /**
     * Execute the console command.
     * @return mixed
     * @throws \App\Exceptions\CurrencyConversionException
     */
    public final function handle(): bool
    {

        $tenants = Customer ::with('website') -> active() -> get();
        foreach($tenants as $tenant) {
            UpdateTenantPairJob ::dispatch($tenant -> website_id);
        }
        return true;

    }
}