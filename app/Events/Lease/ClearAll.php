<?php

namespace App\Events\Lease;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ClearAll
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $model;

    /**
     * ClearAll constructor.
     * @param Model $model
     * @internal param Lease $lease
     */
    public function __construct(Model $model)
    {

        $this -> model = $model;
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
