<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Drive;
use App\Models\LookupName;
use App\Models\LookupValue;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function sinDriverDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_number' => 'required|string',
            'license_issue_date' => 'required|date',
            'license_expiry_date' => 'required|date|after:license_issue_date',
            'vehicle_type' => 'required|numeric|exists:lookup_values,id',
            'vehicle_model' => 'required|numeric|exists:lookup_values,id',
            'car_panel_number_int' => 'required|string',
            'driver_license_image' => 'required|image',
            'vehicle_license_image' => 'required|image',
            'vehicle_insurance_image'=>['required','image'],
            'vehicle_front_image' => 'required|image',
            'vehicle_back_image'=>'required|image',
            'parent_operation_path'=>'required|exists:parent_operation_paths,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'body' => $validator->errors(),
            ]);
        }
        $user=$request->user();

        $driver=Drive::where('user_id',$user->id)->first();
        if ($driver)
            return response()->json([
                'code' => 500,
                'message' => 'User registered as driver',
            ]);
        $images= array_keys($request->allFiles());
        $image_paths=[];
        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $file = $request->file($image);
                $image_path = $file->store('/drivers', ['disk' => 'uploads']);
                $image_paths[$image]=$image_path;
            }
        }
        try {
            DB::beginTransaction();
            $user->drive()->create([
                "license_number"=> $request->license_number,
                "license_issue_date"=>$request->license_issue_date,
                "license_expiry_date"=>$request->license_expiry_date,
                "vehicle_type"=>$request->vehicle_type,
                "vehicle_model"=>$request->vehicle_model,
                "car_panel_number_int"=>$request->car_panel_number_int,
                "parent_operation_path"=>$request->parent_operation_path??1,
                "driver_license_image"=>$image_paths['driver_license_image'],
                "vehicle_license_image"=>$image_paths['vehicle_license_image'],
                "vehicle_insurance_image"=>$image_paths['vehicle_insurance_image'],
                "vehicle_front_image"=>$image_paths['vehicle_front_image'],
                "vehicle_back_image"=>$image_paths['vehicle_back_image'],
                'status'=>LookupValue::where('name_en','deny')->first()->id
            ]);
            $user->type_id=Type::where('name','driver')->first()->id;
            $user->save();
            DB::commit();
            return response()->json([
                'code' => 201,
                'message' => 'Driver Sin in success',
            ]);
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }
    }

    public function changeVerificationCode(Request $request)
    {
        $user=$request->user();
        $user->verification_code_date=now();
        $user->save();
        return response()->json([
            'code' => 200,
            'message' => 'Change verification code success',
        ]);
    }
    public function checkVerificationCode(Request $request)
    {
        $user=$request->user();
        return response()->json([
            'code' => 200,
            'is_verify'=>!is_null($user->verification_code_date),
            'message' => ($user->verification_code_date)?'verify':'not verify',
        ]);
    }

    public function editUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'name' => 'nullable|string',
            'password'=>['nullable', 'confirmed', Password::defaults()],
            'password_confirmation' => 'min:6',
            'image'=>'nullable|image',
            'emergency_number'=>'nullable|numeric',
            'address'=>'nullable|string'
        ]);
//return $request;
        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'body' => $validator->errors(),
            ]);
        }
        $user=\App\Models\User::where('phone_number',$request->post('phone_number'))->first();
        if (!$user)
            return response()->json([
                'code' => 404,
                'body' => 'Not Found user',
            ]);
        $image_path='';
        $new_password='';
        if ($request->hasFile('image'))
        {
            $image_path = $user->image;
            if(File::exists('assets/images/'.$image_path))
                File::delete('assets/images/'.$image_path);

            $file=$request->file('image');
            $image_path=$file->store('/users','uploads');
        }
        if ($request->has('password'))
        {
         $new_password=Has::make($request->post('password'));
        }
        try {
        $user->update([
           'image'=>($image_path!='')?$image_path:$user->image,
           'name'=>($request->name)??$user->name,
           'password'=>($new_password!='')?$new_password:$user->password,
           'address'=>$request->post('address'),
           'emergency_number'=>$request->post('emergency_number')
        ]);
            return response()->json([
                'code' => 200,
                'message' => 'Edit user success',
                'user'=>$user

            ]);
        }catch (\Exception$exception)
        {
            return response()->json([
                'code' => 500,
                'message' => 'Something Error try again',
            ]);
        }
    }
}
