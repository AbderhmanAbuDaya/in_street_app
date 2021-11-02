<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TripEvaluation;
use App\Models\User;
use App\Models\UserEvaluation;
use App\Traits\TraitsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    use TraitsModel;
    public function tripEvaluation(Request $request)
    {
        $user=$request->user();
        $request->merge([
            'client_id'=>$user->id
        ]);
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|string|exists:trips,id',
            'client_id'=>'required|exists:users,id',
            'rating'=>'required|numeric|max:5',
            'feedback'=>'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        try {
            $tripEvaluation=TripEvaluation::where('client_id',$request->post('client_id'))
                ->where('trip_id',$request->post('trip_id'))
                ->first();
            if ($tripEvaluation)
            {
                $tripEvaluation->update($request->only(['rating','feedback']));
                $this->addOrEditLog($user,'edit evaluate trip',' تعديل تقيم رحلة',$user->name.' edit evaluate trip id '.$request->trip_id.' at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
                    $user->name.' تعديل تقيم رحلة المعرفها   '.$request->trip_id .'  عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
                return response()->json([
                    'code' => 200,
                    'message' => 'Edit your rating',
                    'data'=>$tripEvaluation
                ]);
            }

            $tripEvaluation=TripEvaluation::create($request->only(['client_id','trip_id','rating','feedback']));
            $this->addOrEditLog($user,'evaluate trip','تقيم رحلة',$user->name.'evaluate trip id'.$request->trip_id.' at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
                $user->name.' تقيم رحلة المعرفها '.$request->trip_id .'  عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data'=>$tripEvaluation
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }

    }
    public function driveEvaluation(Request $request)
    {
        $user=$request->user();
        $request->merge([
            'user_id'=>$user->id
        ]);
        $validator = Validator::make($request->all(), [
            'drive_id' => 'required|string|exists:users,id',
            'user_id'=>'required|exists:users,id',
            'rating'=>'required|numeric|max:5',
            'feedback'=>'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        try {
            $driveEvaluation=UserEvaluation::where('user_id',$request->post('user_id'))
                ->where('drive_id',$request->post('drive_id'))
                ->first();
            if ($driveEvaluation)
            {
                $driveEvaluation->update($request->only(['rating','feedback']));
                $this->addOrEditLog($user,'edit evaluate drive',' تعديل تقيم السائق ',$user->name.' edit evaluate driver id '.$request->drive_id.' at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
                    $user->name.' تعديل تقيم السائق المعرفه   '.$request->drive_id .'  عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
                return response()->json([
                    'code' => 200,
                    'message' => 'Edit your rating',
                    'data'=>$driveEvaluation
                ]);
            }
             $driver=User::WhereHas('drive')->find($request->post('drive_id'))->first();
              if (!$driver)
                  return response()->json([
                      'code' => 404,
                      'message' => 'Driver Not Found',
                  ]);
            $driveEvaluation=UserEvaluation::create($request->only(['user_id','drive_id','rating','feedback']));
            $this->addOrEditLog($user,'evaluate drive ','تقيم السائق',$user->name.'evaluate drive id '.$request->drive_id.' at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
                $user->name.' تقيم السائق معرفه '.$request->drive_id .'  عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data'=>$driveEvaluation
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }

    }

    public function getUserEvaluation()
    {
        $user=\request()->user();
        $evaluations=$user->tripEvaluation;
        $num=1;
        if ($evaluations->count()>0)
            $num=$evaluations->count();
        $percentage= ($evaluations->avg('rating')/($num*5))*100;
        $yourTrips=$user->pickUpRequest->count();

        return response()->json([
            'code'=>200,
            'message'=>'success',
            'percentage'=>$percentage,
            'numberYourTrips'=>$yourTrips,
            'evaluations'=>$evaluations
        ]);
    }
}
