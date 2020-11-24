<?php

namespace App\Listeners;

use App\Events\System\DeleteFile;
use App\Zen\Setting\Model\AuditTrail;
use Illuminate\Support\Facades\Auth;

class AuditTrailForDeleteFile
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
     * @param  DeleteFile $event
     * @return void
     */
    public function handle(DeleteFile $event)
    {
        $attr = [
            'user_id' => Auth ::id(),
            'table_id' => $event -> tableId,
            'event' => 'File Delete',
            'before' => $event -> file,
            'after' => '',
            'model' => $event -> model,
        ];
        AuditTrail ::create($attr);
    }
}
