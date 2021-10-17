<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
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
         if (Hash::check($request->post('phone_number'),$user->phone_number)){
             return response()->json(
                 [
                     'code' => 200,
                     'message' => 'success',
                     'user' => $user,
                 ]
             );
         }else{
             return response()->json(
                 [
                     'code' => 422,
                     'message' => 'error password',

                 ]
             );
         }

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
        return response()->json([
            'code' => 200,
            'message' => 'token is deleted',
        ]);
    }
}
