<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governate extends Model
{
    use HasFactory;

    protected $fillable=['name_ar','name_en'];

    public function cities()
    {
        return $this->hasMany(City::class);
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
