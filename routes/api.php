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

    Route::post('/login',[\App\Http\Controllers\Api\AuthController::class,'login']);
    Route::post('/register',[\App\Http\Controllers\Api\AuthController::class,'register']);

    Route::post('/sanctum/token', [\App\Http\Controllers\Api\AuthController::class,'createToken']);

    Route::middleware('auth:sanctum')->get('/user/revoke', [\App\Http\Controllers\Api\AuthController::class,'logout']);

   Route::group(['middleware'=>'auth:sanctum'],function (){
       Route::post('/sin/driver',[\App\Http\Controllers\Api\UserController::class,'sinDriverDetails']);
       Route::post('/change-verify-code',[\App\Http\Controllers\Api\UserController::class,'changeVerificationCode']);
       Route::post('/check-verify-code',[\App\Http\Controllers\Api\UserController::class,'checkVerificationCode']);
       Route::get('/all/drivers',[\App\Http\Controllers\Api\DriverController::class,'allDriver'])->middleware(['isAdmin']);
       Route::get('/get/user',function (){
          return \request()->user();
       });

   });
    Route::post('/edit/user',[\App\Http\Controllers\Api\UserController::class,'editUser']);
    Route::get('/all/operation/paths',[\App\Http\Controllers\Api\DriverController::class,'getAllPaths']);
   Route::get('/all/vehicle/types',[\App\Http\Controllers\Api\DriverController::class,'getAllVehicleType']);
   Route::get('/all/vehicle/models',[\App\Http\Controllers\Api\DriverController::class,'getAllVehicleModels']);
});
