<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SyncChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $isSyncing;

    /**
     * Create a new event instance.
     *
     * @param $isSyncing
     */
    public function __construct($isSyncing)
    {
        $this->isSyncing = $isSyncing;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('dashboard');
        //return new PrivateChannel('channel-name');
    }

    public function broadcastAs()
    {
        return 'SyncChanged';
    }
}
