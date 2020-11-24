<?php

namespace App\Events\Lease;

use App\Zen\Lease\Model\Lease;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LeaseChangeDelete
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Lease
     */
    public $lease;
    public $leaseExtensionId;

    /**
     * Create a new event instance.
     * @param Lease $lease
     * @param $leaseExtensionId
     */
    public function __construct(Lease $lease, $leaseExtensionId)
    {

        $this -> lease = $lease;
        $this -> leaseExtensionId = $leaseExtensionId;
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
