<?php

namespace App\Events\System;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DeleteFile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $file;
    public $tableId;
    public $model;

    /**
     * Create a new event instance.
     * @param $file
     * @param $tableId
     * @param $model
     */
    public function __construct($file, $tableId, $model)
    {
        $this -> file = $file;
        $this -> tableId = $tableId;
        $this -> model = $model;
    }

    /**
     * Get the channels the event should broadcast on.
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
