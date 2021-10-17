<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationPath extends Model
{
    use HasFactory;

    protected $fillable=[
         'parent_operation_path_id',
         'source',
        'destination',
        'cost'
    ];

    public function parentOperationPath()
    {
        return $this->belongsTo(ParentOperationPath::class)->withDefault();
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function pickUpRequest()
    {
        return $this->hasMany(PickUpRequest::class);
    }
    public function sourceRegion()
    {
        return $this->belongsTo(Regine::class,'source');
    }
    public function destinationRegion()
    {
        return $this->belongsTo(Regine::class,'destination');
    }
}
