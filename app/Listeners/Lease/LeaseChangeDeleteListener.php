<?php

namespace App\Listeners\Lease;

use App\Events\Lease\LeaseChangeDelete;
use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Model\AuditTrail;
use Illuminate\Support\Facades\Auth;

class LeaseChangeDeleteListener
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
     * @param LeaseChangeDelete $event
     * @return void
     */
    public function handle(LeaseChangeDelete $event)
    {
        $attr = [
            'model' => (new \ReflectionClass(Lease::class)) -> getShortName(),
            'table_id' => $event -> lease -> id,
            'event' => 'Change delete',
            'before' => '',
            'after' => 'Lease Change ' . $event -> leaseExtensionId . ' has been deleted',
            'user_id' => Auth ::id(),
        ];
        AuditTrail ::create($attr);
    }
}
