<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PickUpRequest extends Model
{
    use HasFactory;
protected $table='pick_up_requests';

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
        'current_location',
        'is_custom_location'
    ];
    public $incrementing=false;
    protected $primaryKey='id';

    public function trip()
    {
        return $this->belongsTo(Trip::class,'trip_id')->withDefault();
    }
    public function client()
    {
        return $this->belongsTo(User::class,'client_id')->withDefault();
    }
    public function operationPath()
    {
        return $this->belongsTo(OperationPath::class,'operation_path_id')->withDefault();
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'request_id');
    }
    public function statusType()
    {
        return $this->belongsTo(LookupValue::class,'status')->withDefault();
    }
}
