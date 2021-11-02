<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PickupRequestResource extends JsonResource
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
$data=[];
        $data= [
            'num_seats'=>$this->num_seats,
            'estimated_driver_arrival_time'=>$this->estimated_driver_arrival_time,
            'estimated_arrival_time'=>$this->estimated_arrival_time,
            'actual_arrival_time'=>$this->actual_arrival_time,
            'actual_cost'=>$this->actual_cost,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'client'=>$this->client,
            'trip'=>$this->trip,
            'operation_path'=>[
                [
                    'source'=>$this->operationPath->sourceRegion()->select(['id','name_'.$lang.' as name'])->first(),
                    'destination'=>$this->operationPath->destinationRegion()->select(['id','name_'.$lang.' as name'])->first(),
                    'cost'=>$this->cost
                ]
            ],
            'status'=>$this->statusType()->select(['id','name_'.$lang.' as name'])->first(),
        ];
        if ($this->is_custom_location)
            $data['current_location']=$this->current_location;
        return $data;
    }
}
