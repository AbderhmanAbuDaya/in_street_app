<?php

use App\Http\Middleware\CheckUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Type;

Route::group(['prefix' => 'v1'], function () {

    Route::get('users', function(){
        return User::all();
    });

    Route::get('types', function(){
        return Type::all();
    });

    // Route::get('users/{id}', function($id){
    //     return User::where('id', $id);
    // });

    Route::get('users/{id}', function ($id) {
        $users = Type::find($id);
        if(Type::find($id)) return $users->users;
    });
    Route::post('/login', function (Request $request)
    {
        $old_user = User::where('phone_number', $request->phone_number)->first();
        $user = new User();

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'type_id' => 'required|string',
//            'language' => 'required|string',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'body' => $validator->errors(),
            ]);
        }

        if ($old_user) {
            return response()->json(
                [
                    'code' => 200,
                    'message' => 'success',
                    'user' => $old_user,
                ]
            );
        } else {
            $user->phone_number = $request->get('phone_number');
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
//            $user->language = $request->get('language');
            $user->type_id = $request->get('type_id');
            $user->save();

            return response()->json(
                [
                    'code' => 200,
                    'message' => 'success',
                    'user' => $user,
                ]
            );
        }
    });

//    Route::post('/login',[\App\Http\Controllers\Api\AuthController::class,'login']);
//    Route::post('/register',[\App\Http\Controllers\Api\AuthController::class,'register']);

    Route::post('/sanctum/token', [\App\Http\Controllers\Api\AuthController::class,'createToken']);

    Route::middleware('auth:sanctum')->get('/user/revoke', [\App\Http\Controllers\Api\AuthController::class,'logout']);

   Route::group(['middleware'=>'auth:sanctum'],function (){
       Route::post('/sin/driver',[\App\Http\Controllers\Api\UserController::class,'sinDriverDetails']);
       Route::post('/change-verify-code',[\App\Http\Controllers\Api\UserController::class,'changeVerificationCode']);
       Route::post('/check-verify-code',[\App\Http\Controllers\Api\UserController::class,'checkVerificationCode']);
       Route::group(['middleware'=>'isAdmin'],function (){
           Route::get('/all/drivers',[\App\Http\Controllers\Api\DriverController::class,'allDriver']);
           Route::get('/all/status/driver',[\App\Http\Controllers\Api\DriverController::class,'allStatusDriver']);
           Route::post('/update/status/driver',[\App\Http\Controllers\Api\DriverController::class,'updateStatusDriver']);
           Route::get('/all/active/trip',[\App\Http\Controllers\Api\AdminController::class,'getActiveTrip']);
           Route::get('/all/active/request',[\App\Http\Controllers\Api\AdminController::class,'getActiveRequest']);
           Route::get('/all/logs',[\App\Http\Controllers\Api\LogController::class,'allLogs']);
       });
       Route::get('/get/user',function (){
          return \request()->user();
       });
       Route::group(['middleware'=>'isDriver'],function (){
           Route::get('all/status/trip',[\App\Http\Controllers\Api\TripController::class,'getAllStatusTrip']);
           Route::post('make/trip',[\App\Http\Controllers\Api\TripController::class,'makeTrip']);
           Route::post('update/status/trip/request',[\App\Http\Controllers\Api\TripController::class,'updateStatusTripRequest']);
           Route::post('waiting_driver/pickup/request',[\App\Http\Controllers\Api\TripController::class,'waitingDriverPickupRequest']);
           Route::post('active/pickup/request',[\App\Http\Controllers\Api\TripController::class,'activePickupRequest']);
           Route::post('complete/pickup/request',[\App\Http\Controllers\Api\TripController::class,'completePickupRequest']);
           Route::post('update-number-seats',[\App\Http\Controllers\Api\TripController::class,'updateNumberSeats']);
       });
       Route::get('all/status/pickup/request',[\App\Http\Controllers\Api\TripController::class,'getAllStatusPickupRequest']);
       Route::post('update/status/pickup/request',[\App\Http\Controllers\Api\TripController::class,'updateStatusPickupRequest']);
       Route::post('make/pickup/trip',[\App\Http\Controllers\Api\TripController::class,'pickup_request']);
       Route::post('make/trip/evaluation',[\App\Http\Controllers\Api\EvaluationController::class,'tripEvaluation']);
       Route::get('/all/trip',[\App\Http\Controllers\Api\TripController::class,'index']);
       Route::get('/trip/evaluation',[\App\Http\Controllers\Api\EvaluationController::class,'getUserEvaluation']);
       Route::post('make/drive/evaluation',[\App\Http\Controllers\Api\EvaluationController::class,'driveEvaluation']);
       Route::get('/drive/evaluation',[\App\Http\Controllers\Api\EvaluationController::class,'getDriveEvaluation']);


       Route::post('/device/tokens',[\App\Http\Controllers\Api\DeviceTokenController::class,'store']);
       Route::post('/update/location',[\App\Http\Controllers\Api\UserController::class,'changeLocation']);
   });
   Route::post('/edit/user',[\App\Http\Controllers\Api\UserController::class,'editUser']);
   Route::get('/all/operation/paths',[\App\Http\Controllers\Api\DriverController::class,'getAllPaths']);
   Route::get('/all/vehicle/types',[\App\Http\Controllers\Api\DriverController::class,'getAllVehicleType']);
   Route::get('/all/vehicle/models',[\App\Http\Controllers\Api\DriverController::class,'getAllVehicleModels']);
   Route::get('/all/source',[\App\Http\Controllers\Api\OperationPathController::class,'getAllSource']);
   Route::get('/all/destination/{source}',[\App\Http\Controllers\Api\OperationPathController::class,'getAllDestination']);
Route::get('/d',function (){

     $x=   \App\Models\PickUpRequest::orderBy('created_at','Desc')->first();
     $x->trip_id=2;
     $x->save();
     return 's';
});

Route::get('/whoWeAre',[\App\Http\Controllers\Api\PagesController::class,'getWhoWeAre']);
Route::get('/termsConditions',[\App\Http\Controllers\Api\PagesController::class,'getTermsConditions']);
Route::get('/feedback',[\App\Http\Controllers\Api\PagesController::class,'getFeedback']);
Route::get('/support',[\App\Http\Controllers\Api\PagesController::class,'getSupport']);
Route::get('/socialMedia',[\App\Http\Controllers\Api\PagesController::class,'getSocialMedia']);
});
