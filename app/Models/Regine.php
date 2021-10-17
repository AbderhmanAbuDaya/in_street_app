<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regine extends Model
{
    use HasFactory;
protected $table='regions';
    protected $fillable=[
        'city_id',
        'name_ar',
        'name_en',
        'latitude',
        'longitude'
    ];

    public function city()
    {
        return $this->belongsTo(City::class)->withDefault();
    }

    public function parentOperationPathsTo()
    {
        return $this->morphMany(ParentOperationPath::class, 'toable');
    }
    public function parentOperationPathsForm()
    {
        return $this->morphMany(ParentOperationPath::class, 'fromable');
    }
}
