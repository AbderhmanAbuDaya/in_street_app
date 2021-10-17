<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\OperationPathResource;
use App\Models\LookupName;
use App\Models\OperationPath;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function getAllPaths()
    {
        $lang=\request()->header('lang');
          if (!array_search($lang,['','en','ar']))
                $lang='en';
          \request()->lang=$lang;
        try {
            $paths = OperationPath::select(['id', 'cost', 'source', 'destination'])
                ->with(['sourceRegion' => function ($q) use ($lang) {
                $q->select(['id', 'name_' . $lang .' as name']);
            }, 'destinationRegion' => function ($q) use ($lang) {
                $q->select(['id', 'name_' . $lang .' as name']);
            }])->get();
            return response()->json([
                'code'=>200,
                'message'=>'success',
                'data'=>OperationPathResource::collection($paths)
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code'=>500,
                'message'=>'Something error try again'
            ]);
        }
    }
    public function getAllVehicleType()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;

        try {

            $types=LookupName::with(['values'=>function($q)use($lang){
                $q->select(['lookup_values.id','name_'.$lang .' as name']);
            }])->without('pivot')->where('name','vehicle_size')->first()->values;

            return response()->json([
                'code'=>200,
                'message'=>'success',
                'data'=>$types
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code'=>500,
                'message'=>'Something error try again'
            ]);
        }
    }

    public function getAllVehicleModels()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;

        try {

            $types=LookupName::with(['values'=>function($q)use($lang){
                $q->select(['lookup_values.id','name_'.$lang .' as name']);
            }])->without('pivot')->where('name','vehicle_model')->first()->values;

            return response()->json([
                'code'=>200,
                'message'=>'success',
                'data'=>$types
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code'=>500,
                'message'=>'Something error try again'
            ]);
        }
    }

    public function allDriver()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;
        try {
            $drivers = User::whereHas('type',function(Builder $query){
                $query->where('name','driver');
            })->with(['drive'=>function($query)use($lang){
                $query->with([
                    'statusType'=>function ($q) use($lang){
                    $q->select(['id','name_'.$lang.' as name']);
                       },
                    'vehicleModel'=>function ($q) use($lang){
                        $q->select(['id','name_'.$lang.' as name']);
                    },
                    'vehicleType'=>function ($q) use($lang){
                        $q->select(['id','name_'.$lang.' as name']);
                    },
                    'parentOperationPath'=>function ($q) use($lang){
                    $q->select(['id','to','from']);
                        $q->with([
                            'regionFrom'=>function($form)use($lang){
                            $form->select(['id','name_'.$lang.' as name']);
                        },
                            'regionTo'=>function($to)use($lang){
                                $to->select(['id','name_'.$lang.' as name']);
                            },
                        ]);
                    },

                ]);
        }])->get();
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data'=>DriverResource::collection($drivers)
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }

    }
}
