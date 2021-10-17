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
        'name',
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
        return $this->hasMany(TripEvaluation::class);
    }
    public function pickUpRequest()
    {
        return $this->hasMany(PickUpRequest::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'client_id');
    }
    public function customLocation()
    {
         return $this->hasMany(User::class);
    }
    public function UserEvaluation()
    {
        return $this->hasMany(UserEvaluation::class);
    }


}
