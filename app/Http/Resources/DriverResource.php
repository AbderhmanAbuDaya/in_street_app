<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone_number'=>$this->phone_number,
            'email'=>$this->email,
            'image'=>$this->image,
            'license_number'=>$this->drive->license_number,
            'license_issue_date'=>$this->drive->license_issue_date,
            'license_expiry_date'=>$this->drive->license_expiry_date,
            'vehicle_type'=>$this->drive->vehicleType->name,
            'vehicle_model'=>$this->drive->vehicleModel->name,
            'car_panel_number_int'=>$this->drive->car_panel_number_int,
            'driver_license_image'=>asset('assets/images/'.$this->drive->driver_license_image),
            'vehicle_license_image'=>asset('assets/images/'.$this->drive->vehicle_license_image),
            'vehicle_insurance_image'=>asset('assets/images/'.$this->drive->vehicle_insurance_image),
            'vehicle_front_image'=>asset('assets/images/'.$this->drive->vehicle_front_image),
            'vehicle_back_image'=>asset('assets/images/'.$this->drive->vehicle_back_image),
            'parent_operation_path'=>[
                'to'=>$this->drive->parentOperationPath->regionTo->name,
                'from'=>$this->drive->parentOperationPath->regionFrom->name,
            ],
            'status'=>$this->drive->statusType->name
        ];
    }
}
