<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable=[
        'client_id',
        'request_id',
        'notification_ar',
        'notification_en',
        'is_on_screen',
        'is_sent',
        'is_opened'
    ];

    public function client()
    {
        return $this->belongsTo(User::class,'client_id')->withDefault();
    }
    public function request()
    {
        return $this->belongsTo(PickUpRequest::class,'request_id')->withDefault();
    }
}
