<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;
protected $table='drivers';
    protected $fillable=[
        'user_id',
        'license_number',
        'license_issue_date',
        'license_expiry_date',
        'vehicle_type',
        'vehicle_model',
        'car_panel_number_int',
        'driver_license_image',
        'vehicle_license_image',
        'vehicle_insurance_image',
        'vehicle_front_image',
        'vehicle_back_image',
        'parent_operation_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function parentOperationPath()
    {
        return $this->belongsTo(ParentOperationPath::class,'parent_operation_path')->withDefault();
    }
    public function statusType()
    {
        return $this->belongsTo(LookupValue::class,'status')->withDefault();
    }
    public function vehicleType()
    {
        return $this->belongsTo(LookupValue::class,'vehicle_type')->withDefault();
    }
    public function vehicleModel()
    {
        return $this->belongsTo(LookupValue::class,'vehicle_model')->withDefault();
    }
}
