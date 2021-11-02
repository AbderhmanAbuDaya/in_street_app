<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\OperationPathResource;
use App\Models\LookupName;
use App\Models\LookupValue;
use App\Models\OperationPath;
use App\Models\User;
use App\Traits\TraitsModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class DriverController extends Controller
{
    use TraitsModel;
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
    public function allStatusDriver()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;

        try {

            $types=LookupName::with(['values'=>function($q)use($lang){
                $q->select(['lookup_values.id','name_'.$lang .' as name']);
            }])->without('pivot')->where('name','driver_request_status')->first()->values;

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

    public function updateStatusDriver(Request $request)
    {
        $admin=$request->user();
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:users,id',
            'status_id'=>'required|numeric|exists:lookup_values,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $status= LookupValue::find($request->post('status_id'));
        if(!$status)
            return response()->json([
                'code' => 404,
                'message' => 'Status Not found ',
            ]);
        if (!($status->names[0]->name==='driver_request_status'))
            return response()->json([
                'code' => 500,
                'message' => 'Error choose driver request status ',
            ]);
        $user=User::find($request->user_id);
        if (!$user)
            return response()->json([
                'code' => 404,
                'message' => 'User Not found',
            ]);
        try {
           $afterStatus=$user->drive->statusType;
            $user->drive->status=$request->post('status_id');
            $user->drive->save();
            $beforStatus=$user->drive->statusType;

            $this->addOrEditLog($admin,'change status driver','تغير حالة السائق',$admin->name.' changed the driver '.$user->name.' status from '.$afterStatus->name_en.' to '.$beforStatus->name_en.' at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
                $admin->name.' قام بتغير حالة السائق '.$user->name.'  عند من '.$afterStatus->name_ar.' الي '.$beforStatus->name_ar.''.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
            return response()->json([
                'code'=>200,
                'message'=>'success',
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }

    }
}
