<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable=[
        'id',
        'name',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'image',
        'type_id',
        'verification_code_date',
        'address',
        'emergency_number',
        'is_admin'
    ];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function drive()
    {
        return $this->hasOne(Drive::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function tripEvaluation()
    {
        return $this->hasMany(TripEvaluation::class,'client_id');
    }
    public function pickUpRequest()
    {
        return $this->hasMany(PickUpRequest::class,'client_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'client_id');
    }
    public function customLocation()
    {
         return $this->hasMany(User::class);
    }
    public function userEvaluation()
    {
        return $this->hasMany(UserEvaluation::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class,'logs','user_id','transaction_id','id','id')
            ->withPivot(['log_en','log_ar','created_at']);

    }
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function routeNotificationForFcm($notification = null)
    {

        $x= $this->deviceTokens()->pluck('token')->toArray();
        return $x;
    }


}
