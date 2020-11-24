<?php

namespace App\Listeners\Lease;

use App\Events\Lease\ClearAll;
use App\Zen\Setting\Model\AuditTrail;
use Illuminate\Support\Facades\Auth;

class ClearAllListener
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
     * Handle the event.
     * @param  ClearAll $event
     * @return void
     */
    public function handle(ClearAll $event)
    {
        $attr = [
            'model' => (new \ReflectionClass(get_class($event -> model))) -> getShortName(),
            'table_id' => $event -> model -> id,
            'event' => 'Clear all executed',
            'before' => '',
            'after' => 'Clear all has been executed on ' . $event -> model -> id,
            'user_id' => Auth ::id(),
        ];
        AuditTrail ::create($attr);
    }
}
