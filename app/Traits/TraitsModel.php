<?php

namespace App\Traits;


use App\Models\Log;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;

trait TraitsModel
{
 function addOrEditLog(User $user,$name_en,$name_ar,$log_en,$log_ar)
{
      if (!$user)
           return response()->json([
               'code'=>404,
               'message'=>'Not found'
           ]);
      $transaction=Transaction::where('name_en',$name_en)->first();
      if (!$transaction) {
      $transaction=Transaction::create([
         'name_en'=>$name_en,
         'name_ar'=>$name_ar,
      ]);
      }
    Log::create([
        'id'=>Str::uuid(),
        'user_id'=>$user->id,
        'transaction_id' => $transaction->id,
        'log_ar' => $log_ar,
        'log_en' => $log_en
        ]);


    return  response()->json([
        'code'=>200,
        'message'=>'success'
    ]);

}
}
