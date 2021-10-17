<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable=[
        'drive_id',
        'operation_path_id',
        'status',
        'dateTime',
        'num_available_seats',
        'latitude',
        'longitude'
    ];

    public function drive()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function operationPath()
    {
        return $this->belongsTo(OperationPath::class)->withDefault();
    }
    public function tripEvaluations()
    {
        return $this->hasMany(TripEvaluation::class);
    }
    public function pickUpRequest()
    {
        return $this->hasMany(PickUpRequest::class);
    }
}
