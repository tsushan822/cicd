<?php

namespace App\Events\System;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExecuteCommandEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    public $attr;

    /**
     * Create a new event instance.
     *
     * @param array $attr
     */
    public function __construct(array $attr =  [])
    {
        //
        $this -> attr = $attr;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
