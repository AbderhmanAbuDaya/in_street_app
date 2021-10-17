<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentOperationPath extends Model
{
    use HasFactory;
   protected $guarded=[];
    public function drives()
    {
        return $this->hasMany(Drive::class);
    }


    public function operationPaths()
    {
        return $this->hasMany(OperationPath::class);
    }
    public function regionTo()
    {
        return $this->belongsTo(Regine::class,'to');
    }
    public function regionFrom()
    {
        return $this->belongsTo(Regine::class,'from');
    }
}
