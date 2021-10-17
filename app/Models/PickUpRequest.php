<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PickUpRequest extends Model
{
    use HasFactory;


    protected $fillable=[
        'client_id',
        'trip_id',
        'operation_path_id',
        'status',
        'num_seats',
        'estimated_driver_arrival_time',
        'estimated_arrival_time',
        'actual_arrival_time',
        'latitude',
        'longitude',
        'actual_cost',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class)->withDefault();
    }
    public function client()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function operationPath()
    {
        return $this->belongsTo(OperationPath::class)->withDefault();
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'request_id');
    }
}
