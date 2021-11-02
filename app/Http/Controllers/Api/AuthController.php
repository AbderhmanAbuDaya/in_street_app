<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\TraitsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use TraitsModel;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'body' => $validator->errors(),
            ]);
        }
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user)
        {
            return response()->json(
                [
                    'code' => 404,
                    'message' => 'not found',
                ]
            );
        }

        $user->token=$user->createToken($request->device_name)
            ->plainTextToken;


             $this->addOrEditLog($user,'login','تسجيل الدخول',$user->name.'login at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
                  $user->name.'سجل الدخول عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
             return response()->json(
                 [
                     'code' => 200,
                     'message' => 'success',
                     'user' => $user,
                 ]
             );


    }

    public function register(Request $request)
       {

           $validator = Validator::make($request->all(), [
               'phone_number' => 'required|string|unique:users,phone_number',
               'name' => 'required|string',
               'type_id' => 'required|string|exists:types,id',
               'email' => 'required|unique:users,email',
               'password'=>['required', 'confirmed', Password::defaults()],
               'password_confirmation' => 'min:6',
               'device'=>'nullable|string',
               'image'=>'nullable|image',
           ]);

           if ($validator->fails()) {
               return response()->json([
                   'code' => 422,
                   'body' => $validator->errors(),
               ]);
           }
           $image_path='';
           if ($request->hasFile('image'))
           {
               $file=$request->file('image');

               $image_path=$file->store('/users',['disk'=>'uploads']);

           }
           $request->password=Hash::make($request->password);
//           return $request->only(['phone_number','name','type_id','email','password']);
           $user=User::create([
               'phone_number'=>$request->phone_number,
               'name'=>$request->name,
               'type_id'=>$request->type_id,
               'email'=>$request->email,
               'image'=>$image_path,
               'password'=>Hash::make($request->password)
           ]);
           if ($user)
           $token=$user->createToken($request->device??'idk')->plainTextToken;
           $user->token=$token;
        $this->addOrEditLog($user,'sinUp','انشاء حساب',$user->name.'sinUp at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
            $user->name.'انشاء حساب عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
            return response()->json([
                'code'=>200,
                'body'=>$user
            ]);


       }

    public function createToken(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json([
                'code' => 422,
                'message' => 'User not found',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'token' => $user->createToken($request->device_name)
                ->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $this->addOrEditLog($user,'logout','تسجيل خروج',$user->name.'logout at '.Carbon::now()->toDateTimeString().' \n ip:'.$request->ip(),
            $user->name.'سجل خروج عند  '.Carbon::now()->toDateTimeString().' \n عنوان ip:'.$request->ip());
        return response()->json([
            'code' => 200,
            'message' => 'token is deleted',
        ]);
    }
}
