<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupName extends Model
{
    use HasFactory;
    protected $fillable=['id','name'];
    protected $hidden = array('pivot');

    public function values()
    {
        return $this->belongsToMany(LookupValue::class,'lookups','lookup_id','value_id','id','id');
    }
}
