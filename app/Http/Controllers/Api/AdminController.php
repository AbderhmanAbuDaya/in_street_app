<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PickupRequestResource;
use App\Http\Resources\TripResourese;
use App\Models\PickUpRequest;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getActiveTrip()
    {
         $trips=Trip::whereHas('statusType',function (Builder $query){
             $query->where('name_en','active');
         })->get();
          return response()->json([
              'code'=>200,
              'message'=>'success',
              'data'=>TripResourese::collection($trips),
          ]);
    }
    public function getActiveRequest()
    {
        $requests=PickUpRequest::whereHas('statusType',function (Builder $query){
            $query->where('name_en','active');
        })->get();
        return response()->json([
            'code'=>200,
            'message'=>'success',
            'data'=>PickupRequestResource::collection($requests),
        ]);
    }
}
