<?php

namespace App\Listeners;

use App\Notifications\TrackingNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\PickUpRequest;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;

class SendTrackingNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user=$event->user;
        $drive=$user->drive;
        if ($drive) {
            $trip = Trip::where('drive_id', $user->id)
                ->whereHas('statusType', function (Builder $query) {
                    $query->where('name_en', 'active');
                })->orderBy('created_at','Desc')->first();

            if (!$trip)
                return;
            $trip->update([
                'latitude'=>$event->latitude,
                'longitude'=>$event->longitude
            ]);

           $pickupRequest=PickUpRequest::where('trip_id',$trip->id)
               ->whereHas('statusType',function (Builder $query){
                   $query->where('name_en','waiting_driver');
           })->orderBy('created_at','Desc')->first();
            if (!$pickupRequest)
                return;
            $userToSend=$pickupRequest->client;
            $userToSend->notify(new TrackingNotification($user->id,$event->latitude,$event->longitude));
          return;
        }

        $pickupRequest=PickUpRequest::where('client_id',$user->id)
            ->whereHas('statusType',function (Builder $query){
                $query->where('name_en','waiting_driver');
            })->orderBy('created_at','Desc')->first();
        if (!$pickupRequest)
            return ;
        $pickupRequest->update([
            'latitude'=>$event->latitude,
            'longitude'=>$event->longitude
        ]);
        $trip = $pickupRequest->trip;

        if (!$trip)
            return ;
        $userToSend=$trip->drive;
        $userToSend->notify(new TrackingNotification($user,$event->latitude,$event->longitude));
        return;
    }
}
