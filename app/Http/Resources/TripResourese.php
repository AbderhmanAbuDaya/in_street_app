<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResourese extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang=$request->header('lang');

        return [
            'id'=>$this->id,
            'dateTime'=>$this->dateTime,
            'num_available_seats'=>$this->num_available_seats,
            'status'=>$this->statusType()->select(['id','name_'.$lang.' as name'])->first(),
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'operation_path'=>[
//                'id'=>$this->operation_path->id,
                'source'=>$this->operationPath->sourceRegion()->select(['id','name_'.$lang.' as name'])->first(),
                'destination'=>$this->operationPath->destinationRegion()->select(['id','name_'.$lang.' as name'])->first(),
                'cost'=>$this->cost
            ],
            'driver'=>[
                'id'=>$this->drive->id,
                'name'=>$this->drive->name,
                'phone_number'=>$this->drive->phone_number,
                'email'=>$this->drive->email,
                'image'=>$this->drive->image,
                'vehicle_type'=>$this->drive->drive->vehicleType()->select(['id','name_'.$lang.' as name'])->first(),
                'vehicle_model'=>$this->drive->drive->vehicleModel()->select(['id','name_'.$lang.' as name'])->first(),
                'car_panel_number_int'=>$this->drive->drive->car_panel_number_int,
                'driver_license_image'=>asset('assets/images/'.$this->drive->drive->driver_license_image),
                'vehicle_license_image'=>asset('assets/images/'.$this->drive->drive->vehicle_license_image),
                'vehicle_insurance_image'=>asset('assets/images/'.$this->drive->drive->vehicle_insurance_image),
                'vehicle_front_image'=>asset('assets/images/'.$this->drive->drive->vehicle_front_image),
                'vehicle_back_image'=>asset('assets/images/'.$this->drive->drive->vehicle_back_image),
            ],
        ];
    }
}
