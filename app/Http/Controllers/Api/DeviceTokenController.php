<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token'=>'required',
            'device'=>'required',
            'type'=>'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => $validator->errors(),
            ]);
        }
        $user=Auth::guard('sanctum')->user();
        $user->deviceTokens()->create($request->all());
        return ;
    }
}
