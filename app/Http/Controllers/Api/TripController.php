<?php

namespace App\Http\Controllers\Api;

use App\Events\SendNotficationToClient;
use App\Events\SendNotificationToDriver;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationTripResourese;
use App\Jobs\SendNearDriver;
use App\Models\CustomLocation;
use App\Models\LookupName;
use App\Models\LookupValue;
use App\Models\OperationPath;
use App\Models\PickUpRequest;
use App\Models\Trip;
use App\Traits\TraitsModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TripController extends Controller
{
    use TraitsModel;
    public function getAllStatusTrip()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;

        try {

            $types=LookupName::with(['values'=>function($q)use($lang){
                $q->select(['lookup_values.id','name_'.$lang .' as name']);
            }])->without('pivot')->where('name','trip_status')->first()->values;

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
    public function getAllStatusPickupRequest()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;

        try {

            $types=LookupName::with(['values'=>function($q)use($lang){
                $q->select(['lookup_values.id','name_'.$lang .' as name']);
            }])->without('pivot')->where('name','pickup_request_status')
                ->first()->values;

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
    public function makeTrip(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'source' => 'required|numeric|exists:operation_paths,source',
            'destination'=>'required|numeric|exists:operation_paths,destination',
            'status_id'=>'nullable|numeric|exists:lookup_values,id',
            'current_location'=>'required_without:source,destination|string',
            'num_available_seats'=>'required|numeric',
            'longitude'=>'required',
            'latitude'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        if ($request->post('current_location'))
        {
            CustomLocation::create([
                'user_id'=>$user->id,
                'name'=>$request->post('current_location'),
                'latitude'=>$request->post('latitude'),
                'longitude'=>$request->post('longitude'),
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
        $operationPath=OperationPath::where('source',$request->post('source'))
                      ->where('destination',$request->post('destination'))->first();
        if (!$operationPath)
            return response()->json([
                'code' => 404,
                'message' => 'Operation Path Not found ',
            ]);
        if ($request->post('status_id'))
            $status= LookupValue::where('name_en',$request->post('status_id'))->first();
        else
        $status= LookupValue::where('name_en','active')->whereHas('names',function (Builder $query){
            $query->where('name','trip_status');
        })->first();
        if(!$status)
            return response()->json([
                'code' => 404,
                'message' => 'Status Not found ',
            ]);
        if (!($status->names[0]->name==='trip_status'))
            return response()->json([
                'code' => 500,
                'message' => 'Error choose trip status ',
            ]);
        $trip=Trip::where('drive_id',$user->id)->whereHas('statusType',function (Builder $query){
            $query->where('name_en','active')->orWhere('name_en','incomplete');
        })->get();
        if (count($trip)>0)
            return response()->json([
                'code' => 422,
                'message' => 'You are on another trip You must close the previous trip before creating another trip ',
            ]);
        try {
            $pickup_trip=new Trip();
            $pickup_trip->drive_id=$user->id;
            $pickup_trip->operation_path_id=$operationPath->id;
            $pickup_trip->status=$status->id;
            $pickup_trip->dateTime=now();
            $pickup_trip->is_custom_location=$request->post('current_location')?true:false;
            $pickup_trip->current_location=$request->post('current_location');
            $pickup_trip->num_available_seats=$request->post('num_available_seats');
            $pickup_trip->longitude=$request->post('longitude');
            $pickup_trip->latitude=$request->post('latitude');
            $pickup_trip->save();
            $this->addOrEditLog($user,'make trip','انشاء رحلة','driver '.$user->name.' made trip at '.Carbon::now()->toDateTimeString().' \n id trip is'.$pickup_trip->id.' \n ip:'.$request->ip(),
                $user->name.'انشأ رحلة  عند  '.Carbon::now()->toDateTimeString().' \n معرف الرحلة  '.$pickup_trip->id.' \n عنوان ip:'.$request->ip());
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

    public function pickup_request(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'source' => 'required|numeric|exists:operation_paths,source',
            'destination'=>'required|numeric|exists:operation_paths,destination',
            'current_location'=>'required_without:source,destination|string',
            'number_of_seats_needed'=>'required|numeric',
            'longitude'=>'required',
            'latitude'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $operationPath=OperationPath::where('source',$request->post('source'))
            ->where('destination',$request->post('destination'))->first();
        if (!$operationPath)
            return response()->json([
                'code' => 404,
                'message' => 'Operation Path Not found ',
            ]);
        $status=LookupValue::whereHas('names',function (Builder  $q){
            $q->where('name','pickup_request_status');
        })->where('name_en','pending_approval')->first();
        try {
            $pickup_trip=new PickUpRequest();
            $pickup_trip->id=Str::uuid();
            $pickup_trip->client_id=$user->id;
            $pickup_trip->operation_path_id=$operationPath->id;
            $pickup_trip->status=$status->id;
            $pickup_trip->is_custom_location=$request->post('current_location')?true:false;
            $pickup_trip->current_location=$request->post('current_location');
            $pickup_trip->num_seats=$request->post('number_of_seats_needed');
            $pickup_trip->longitude=$request->post('longitude');
            $pickup_trip->latitude=$request->post('latitude');
            $pickup_trip->save();
            $trips=Trip::where('operation_path_id',$pickup_trip->operation_path_id)
                ->where('num_available_seats','>=',$pickup_trip->num_seats)
                ->whereHas('statusType',function (Builder $query){
                    $query->where('name_en','active')->orWhere('name_en','incomplete');
            })->get();
            foreach ($trips as $trip)
            {
                $trip->distance=$this->vincentyGreatCircleDistance($pickup_trip->latitude,$pickup_trip->longitude,$trip->latitude,$trip->longitude);
            }
             $trips->sortBy('distance');
          foreach ($trips as $i=>$trip)
          {
              dispatch(new SendNearDriver(new SendNotificationToDriver($pickup_trip->load(['operationPath','client','trip']),$trip)))
                  ->delay(now()->addSeconds(30*$i));
          }



            $this->addOrEditLog($user,'make pickup request','طلب بيك اب','client '.$user->name.' made pickup request at '.Carbon::now()->toDateTimeString().' \n id trip is'.$pickup_trip->id.' \n ip:'.$request->ip(),
                $user->name.'طلب المستخدم بيك اب  عند  '.Carbon::now()->toDateTimeString().' \n معرف الرحلة  '.$pickup_trip->id.' \n عنوان ip:'.$request->ip());
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
    public function updateStatusPickupRequest(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'pickup_request_id' => 'required|string|exists:pick_up_requests,id',
            'status'=>'required|string|exists:lookup_values,name_en',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $pickup_request=PickUpRequest::where('id',$request->post('pickup_request_id'))->first();
        $status=LookupValue::where('name_en',$request->post('status'))->whereHas('names',function (Builder  $q){
        $q->where('name','pickup_request_status');
        })->where(function ($q){
            $q->where('name_en','ignored')->orWhere('name_en','rejected')->orWhere('name_en','waiting_driver');
          })->first();
        if (!$status)
            return response()->json([
                'code' => 500,
                'message' => 'Error choose trip status ',
            ]);
        try {
            $pickup_request->status=$status->id;
            $pickup_request->save();
            broadcast(new SendNotficationToClient([
                'pickup_request_id'=>$pickup_request->id,
                'status'=>$pickup_request->statusType->name_en,
                'client_id'=>$pickup_request->client_id
            ]));
            $this->addOrEditLog($user,$status->name_en.' pickup request',$status->name_ar.' بيك اب','driver '.$user->name.' '.$status->name_en.' pickup request'.Carbon::now()->toDateTimeString().' \n id pickup request is'.$pickup_request->id.' \n ip:'.$request->ip(),
                'السائق '.$user->name.$status->name_ar.' بيك اب'.Carbon::now()->toDateTimeString().' \n معرف بيك اب  '.$pickup_request->id.' \n عنوان ip:'.$request->ip());
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
    public function updateStatusTripRequest(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|string|exists:trips,id',
            'status'=>'required|string|exists:lookup_values,name_en',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $trip=Trip::where('id',$request->post('trip_id'))->first();
        $status=LookupValue::where('name_en',$request->post('status'))->whereHas('names',function (Builder  $q){
        $q->where('name','trip_status');
        })->where(function ($q){
            $q->where('name_en','incomplete')->orWhere('name_en','complete')->orWhere('name_en','active');
          })->first();
        if (!$status)
            return response()->json([
                'code' => 500,
                'message' => 'Error choose trip status ',
            ]);
        try {
            $trip->status=$status->id;
            $trip->save();
            $this->addOrEditLog($user,$status->name_en.' trip',$status->name_ar.' رحلة','driver '.$user->name.' '.$status->name_en.' trip'.Carbon::now()->toDateTimeString().' \n id trip is'.$trip->id.' \n ip:'.$request->ip(),
                'السائق '.$user->name.$status->name_ar.' رحلة '.Carbon::now()->toDateTimeString().' \n معرف رحلة  '.$trip->id.' \n عنوان ip:'.$request->ip());
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
    public  function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    public function waitingDriverPickupRequest(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'pickup_request_id' => 'required|string|exists:pick_up_requests,id',
            'trip_id'=>'required|string|exists:trips,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $trip=Trip::where('id',$request->post('trip_id'))->whereHas('statusType',function (Builder $query){
            $query->where('name_en','!=','complete');
        })->first();
        if (!$trip)
            return response()->json([
                'code' => 404,
                'message' => 'Not found or trip is completed',
            ]);
        $pickup_request=PickUpRequest::where('id',$request->post('pickup_request_id'))
            ->whereHas('statusType',function (Builder $query){
                $query->where('name_en','!=','complete')->where('name_en','!=','active')->where('name_en','!=','waiting_driver');
            })->first();
        if (!$pickup_request)
            return response()->json([
                'code' => 404,
                'message' => 'Not found or pickup request is [completed or active or waiting_driver]',
            ]);

        if ($trip->num_available_seats < $pickup_request->num_seats)
        {
            return response()->json([
                'code' => 500,
                'message' => 'There are not enough seats available',
            ]);
        }

        try {
            DB::beginTransaction();
            $pickup_request->trip_id=$trip->id;
            $status=LookupValue::where('name_en','waiting_driver')
                ->whereHas('names',function (Builder  $q){
                    $q->where('name','pickup_request_status');
                })->first();
            $pickup_request->status=$status->id;
            $pickup_request->save();

            $trip->num_available_seats-=$pickup_request->num_seats;
            $trip->save();
            $this->addOrEditLog($user,$status->name_en.' pickup request',$status->name_ar.' بيك اب','driver '.$user->name.' '.$status->name_en.' pickup request'.Carbon::now()->toDateTimeString().' \n id pickup request is'.$pickup_request->id.' \n ip:'.$request->ip(),
                'السائق '.$user->name.$status->name_ar.' بيك اب'.Carbon::now()->toDateTimeString().' \n معرف بيك اب  '.$pickup_request->id.' \n عنوان ip:'.$request->ip());
            DB::commit();
            broadcast(new SendNotficationToClient([
                'pickup_request_id'=>$pickup_request->id,
                'trip_id'=>$trip->id,
                'client_id'=>$pickup_request->client_id,
                'driver_id'=>$trip->drive_id,
                'driver_name'=>$trip->drive->name,
                'driver_latitude'=>$trip->latitude,
                'driver_longitude'=>$trip->longitude,
                'estimated_driver_arrival_time'=>$pickup_request->estimated_driver_arrival_time,
                'estimated_arrival_time'=>$pickup_request->estimated_arrival_time,
                'actual_arrival_time'=>$pickup_request->actual_arrival_time,
                'actual_cost'=>$pickup_request->actual_cost,
                'vehicle_type'=>$trip->drive->drive->vehicleType->name_en,
                'vehicle_model'=>$trip->drive->drive->vehicleModel->name_en,
                'status'=>$pickup_request->statusType->name_en
            ]));
            return response()->json([
                'code'=>200,
                'message'=>'success',
                'data'=>[
                    'pickup_request_id'=>$pickup_request->id,
                    'trip_id'=>$trip->id,
                    'client_id'=>$pickup_request->client_id,
                    'client_name'=>$pickup_request->client->name,
                    'client_latitude'=>$pickup_request->latitude,
                    'client_longitude'=>$pickup_request->longitude,
                    'status'=>$pickup_request->statusType->name_en
                ]
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }

    }
    public function activePickupRequest(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'pickup_request_id' => 'required|string|exists:pick_up_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }

        $pickup_request=PickUpRequest::where('id',$request->post('pickup_request_id'))
            ->whereHas('statusType',function (Builder $query){
                $query->where('name_en','!=','complete')->where('name_en','!=','active');
            })->first();
        if (!$pickup_request)
            return response()->json([
                'code' => 404,
                'message' => 'Not found or pickup request is [completed or active ]',
            ]);
        try {
            $status=LookupValue::where('name_en','active')
                ->whereHas('names',function (Builder  $q){
                    $q->where('name','pickup_request_status');
                })->first();
            $pickup_request->status=$status->id;
            $pickup_request->save();
            $this->addOrEditLog($user,$status->name_en.' pickup request',$status->name_ar.' بيك اب','driver '.$user->name.' '.$status->name_en.' pickup request'.Carbon::now()->toDateTimeString().' \n id pickup request is'.$pickup_request->id.' \n ip:'.$request->ip(),
                'السائق '.$user->name.$status->name_ar.' بيك اب'.Carbon::now()->toDateTimeString().' \n معرف بيك اب  '.$pickup_request->id.' \n عنوان ip:'.$request->ip());
            return response()->json([
                'code'=>200,
                'message'=>'success',
                'data'=>[
                    'pickup_request_id'=>$pickup_request->id,
                    'status'=>$pickup_request->statusType->name_en,
                ]
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }
    }
 public function completePickupRequest(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'pickup_request_id' => 'required|string|exists:pick_up_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }

        $pickup_request=PickUpRequest::where('id',$request->post('pickup_request_id'))
            ->whereHas('statusType',function (Builder $query){
                $query->where('name_en','!=','complete');
            })->first();
        if (!$pickup_request)
            return response()->json([
                'code' => 404,
                'message' => 'Not found or pickup request is [completed or active ]',
            ]);
        try {
            DB::beginTransaction();
            $status=LookupValue::where('name_en','complete')
                ->whereHas('names',function (Builder  $q){
                    $q->where('name','pickup_request_status');
                })->first();
            $pickup_request->status=$status->id;
            $pickup_request->save();
            $trip=Trip::find($pickup_request->trip_id);
             $trip->num_available_seats+=$pickup_request->num_seats;
             $trip->save();
            $this->addOrEditLog($user,$status->name_en.' pickup request',$status->name_ar.' بيك اب','driver '.$user->name.' '.$status->name_en.' pickup request'.Carbon::now()->toDateTimeString().' \n id pickup request is'.$pickup_request->id.' \n ip:'.$request->ip(),
                'السائق '.$user->name.$status->name_ar.' بيك اب'.Carbon::now()->toDateTimeString().' \n معرف بيك اب  '.$pickup_request->id.' \n عنوان ip:'.$request->ip());
             DB::commit();
            return response()->json([
                'code'=>200,
                'message'=>'success',
                'data'=>[
                    'pickup_request_id'=>$pickup_request->id,
                    'status'=>$pickup_request->statusType->name_en,
                ]
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }
    }

    public function updateNumberSeats(Request $request)
    {
        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|string|exists:trips,id',
            'num_available_seats'=>'required|numeric|max:7'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $trip=Trip::where('id',$request->post('trip_id'))
            ->whereHas('statusType',function (Builder $query){
             $query->where('name_en','active');
        })->first();
        if (!$trip)
            return response()->json([
                'code' => 404,
                'message' => 'Not found or trip not active',
            ]);
        if ($trip->drive->drive->vehicleType->name_en=='large'){
            if ($request->num_available_seats >7 )
                return response()->json([
                    'code' => 500,
                    'message' => 'The number of available seats must be less than or equal to 7',
                ]);
        }else{
            if ($request->num_available_seats >4)
                return response()->json([
                    'code' => 500,
                    'message' => 'The number of available seats must be less than or equal to 4',
                ]);
        }

        try {
            $beforeSeats=$trip->num_available_seats;
            $trip->num_available_seats=$request->post('num_available_seats');
            $afterSeats=$trip->num_available_seats;
            $trip->save();
            $this->addOrEditLog($user,'change available seats','تعديل المقاعد المتاحة','driver '.$user->name.' change number available seats from '.$beforeSeats.' to '. $afterSeats.' at'.Carbon::now()->toDateTimeString().'\n id trip is'.$trip->id.' \n ip:'.$request->ip(),
                'السائق: '.$user->name.'  قام بتغير المقاعر المتاحة من  '.$beforeSeats.'  الى  '. $afterSeats.'  عند '.Carbon::now()->toDateTimeString().'\n  معرف الرحلة هو : '.$trip->id.' \n العنوان ip:'.$request->ip());
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data'=>$trip->unsetRelation('drive')
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }

    }

    public function index()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;
        try {
            $trips=Trip::paginate(10);
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data'=>new PaginationTripResourese($trips)
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }


    }

}
