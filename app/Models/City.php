<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable=[
        'governate_id',
        'name_ar',
        'name_en',
        'latitude',
        'longitude'
    ];

    public function governate()
    {
        return $this->belongsTo(Governate::class)->withDefault();
    }

    public function regiens()
    {
        return $this->hasMany(Regine::class);
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
