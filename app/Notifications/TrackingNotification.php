<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;


class TrackingNotification extends Notification
{
    use Queueable;
public $user,$latitude,$longitude;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $latitude,$longitude)
    {
        $this->user=User::find($user);
        $this->latitude=$latitude;
        $this->longitude=$longitude;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toFcm($notifiable){
        $x= FcmMessage::create()
            ->setData([
                'latitude'=>$this->latitude,
                'longitude'=>$this->longitude,
                'user'=>"$this->user",
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK',

            ]) //extra data
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Tracking')
              //  ->setBody('Your account has been activated.')
//                ->setImage('http://example.com/url-to-image-here.png')
            );
     return $x;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
