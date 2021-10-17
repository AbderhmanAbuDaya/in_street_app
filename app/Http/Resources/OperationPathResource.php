<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OperationPathResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang=$request->lang;;

        return [
            'id'=>$this->id,
            'cost'=>$this->cost,
            'source'=>$this->sourceRegion,
            'destination'=>$this->destinationRegion,

        ];
    }
}
