<?php

namespace App\Http\Resources;

use App\Http\Controllers\Api\TripController;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationTripResourese extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

//        dd($this->items());
        return [
        'current_page'=>$this->count(),
        'first_page_url'=>$this->url(1),
        'from'=>$this->firstItem(),
        'last_page'=>$this->lastPage(),
        'last_page_url'=>$this->url($this->lastPage()),
        'next_page_url'=>$this->nextPageUrl(),
        'path'=>$this->getOptions()['path'],
        'per_page'=>$this->perPage(),
        'prev_page_url'=>$this->previousPageUrl(),
        'to'=>$this->lastItem(),
        'total'=>$this->total(),
        'data'=> TripResourese::collection($this->items()),
    ];
    }
}
