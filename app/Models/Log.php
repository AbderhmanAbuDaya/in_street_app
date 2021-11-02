<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table='logs';
    protected $fillable=['id','user_id','transaction_id','log_ar','log_en'];
    protected $appends=['created_at'];
 public $incrementing=false;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id')->withDefault();
    }
    public function getCreatedAtAttribute($value)
    {
        return $this->created_at->format('d.m.Y');
    }

}
