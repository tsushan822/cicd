<?php

namespace App\Listeners\User;

use App\Zen\User\Model\FailedLoginAttempt;
use Illuminate\Auth\Events\Failed;

class RecordFailedLoginAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        FailedLoginAttempt::record(
            $event->credentials['email'],
            request()->ip(),
            $event->user
        );
    }
}
