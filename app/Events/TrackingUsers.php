<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TrackingUsers
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public  $user,$latitude,$longitude;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$latitude,$longitude)
    {
        $this->user=$user;
        $this->latitude=$latitude;
        $this->longitude=$longitude;
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
