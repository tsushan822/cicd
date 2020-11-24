<?php

namespace App\Listeners\System;

use App\Events\System\DownloadFile;
use App\Zen\Setting\Model\AuditTrail;
use Illuminate\Support\Facades\Auth;

class AuditTrailForDownloadFile
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
     * @param  DownloadFile  $event
     * @return void
     */
    public function handle(DownloadFile $event)
    {
        $attr = [
            'user_id' => Auth ::id(),
            'table_id' => $event -> tableId,
            'event' => 'File Download',
            'before' => $event -> file,
            'after' => $event -> file,
            'model' => $event -> model,
        ];
        AuditTrail ::create($attr);
    }
}
