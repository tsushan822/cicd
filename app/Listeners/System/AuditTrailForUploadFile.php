<?php

namespace App\Listeners;

use App\Events\System\UploadFile;
use App\Zen\Setting\Model\AuditTrail;
use Illuminate\Support\Facades\Auth;

class AuditTrailForUploadFile
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
     * @param  UploadFile $event
     * @return void
     */
    public function handle(UploadFile $event)
    {
        $attr = [
            'user_id' => Auth ::id(),
            'table_id' => $event -> tableId,
            'event' => 'File Upload',
            'before' => '',
            'after' => $event -> file -> getClientOriginalName(),
            'model' => $event -> model,
        ];
        AuditTrail ::create($attr);
    }
}
