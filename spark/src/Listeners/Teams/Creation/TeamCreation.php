<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 2020-03-26
 * Time: 15:59
 */

namespace Laravel\Spark\Listeners\Teams\Creation;


use App\Jobs\System\CreateCustomerJob;

class TeamCreation
{
    /**
     * Handle the event.
     * @param  mixed $event
     * @return void
     */
    public function handle($event)
    {
        $customerData['fx_rate_source'] = null;
        $customerData['name'] = $event -> team -> name;
        $customerData['fqdn'] = config('zenlease.temporary_subdomain') . '.' . config('zenlease.server_url');
        $customerData['team_id'] = $event -> team -> id;
        CreateCustomerJob ::dispatch($customerData);

    }
}