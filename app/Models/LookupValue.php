<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupValue extends Model
{
    use HasFactory;
    protected $fillable=['id','name_ar','name_en'];
    protected $hidden = array('pivot');

    public function names()
    {
        return $this->belongsToMany(LookupName::class,'lookups','value_id','lookup_id','id','id');
    }
}
