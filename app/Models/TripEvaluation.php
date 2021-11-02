<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripEvaluation extends Model
{
    use HasFactory;
 protected $table='trip_evaluation';
    protected $fillable=[
        'trip_id',
        'client_id',
        'rating',
        'feedback'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class)->withDefault();
    }
    public function client()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
