<?php

namespace App\Events;

use App\Models\PickUpRequest;
use App\Models\Trip;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationToDriver implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $pickup_trip,$trip;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PickUpRequest $pickup_trip,Trip $trip)
    {
        $this->pickup_trip=$pickup_trip;
        $this->trip=$trip;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        Log::info($this->pickup_trip);
//        Log::info($this->trip);
//        Log::info(gettype($this->pickup_trip));
        $x= PickUpRequest::where('id',$this->pickup_trip->id)->first();
        if (is_null($x->trip_id))
            return new Channel('notification-driver'.$this->trip->drive_id);
    }

}
