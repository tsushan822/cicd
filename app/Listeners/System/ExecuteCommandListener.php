<?php

namespace App\Listeners\System;

use App\Events\System\ExecuteCommandEvent;
use App\Zen\System\Model\ExecuteCommand;


class ExecuteCommandListener
{

    /**
     * Handle the event.
     *
     * @param  ExecuteCommandEvent  $event
     * @return void
     */
    public function handle(ExecuteCommandEvent $event)
    {
        ExecuteCommand::create($event->attr);
    }
}
