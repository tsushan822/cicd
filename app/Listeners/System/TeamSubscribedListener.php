<?php


namespace App\Listeners\System;

use Laravel\Spark\Events\Teams\Subscription\TeamSubscribed;

class TeamSubscribedListener
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * @param TeamSubscribed $event
     */
    public function handle(TeamSubscribed $event)
    {
        $customer = $event -> team -> customer;
        $website = $customer -> website;
        $website -> stripe_customer_id = $event -> team -> stripe_id;
        $website -> save();
    }
}