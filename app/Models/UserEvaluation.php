<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvaluation extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'drive_id',
        'rating',
        'feedback'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function drive()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
