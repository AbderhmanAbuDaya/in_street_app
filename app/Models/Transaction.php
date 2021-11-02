<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table='transactions';
    protected $fillable=['name_en','name_ar'];

    public function user()
    {
        return $this->belongsToMany(User::class,'logs','transaction_id','user_id','id','id')
            ->withPivot(['log_en','log_ar','created_at']);

    }
}
