<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{
    public function allLogs()
    {
        $request=\request();
//        $validator = Validator::make($request->header(), [
//            'date_from' => 'nullable|date',
//            'date_to'=>'nullable|date|after:date_to',
//            'user_id'=>'required|numeric|exists:users,id',
//            'transaction_id'=>'required|numeric|exists:transactions,id',
//            'lang'=>'required|string|in:ar,en'
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'code' => 422,
//                'message' => $validator->errors(),
//            ]);
//        }
//return is_null(\request()->header('date_from'));
//return  User::with('transactions')->get();
$x= Transaction::with('user')->where('id',$request->header('transaction_id'))->first();
$transactions= $x->user->pluck('pivot')->map(function ($item,$key){
  return  $item->only(['log_'.\request()->header('lang'),'created_at']);
});
if (\request()->header('date_from')&&\request()->header('date_to')) {
    $transactions=  $transactions->filter(function ($item){

        return  strftime("%d-%m-%Y",strtotime($item['created_at'])) >=\request()->header('date_from')&&
                   strftime("%d-%m-%Y",strtotime($item['created_at'])) <=\request()->header('date_to');
    });

return '1';
}elseif (\request()->header('date_from')) {
  $transactions=  $transactions->filter(function ($item){

        return  strftime("%d-%m-%Y",strtotime($item['created_at'])) >=\request()->header('date_from');
    });

}elseif (\request()->header('date_to')) {
    $transactions=  $transactions->filter(function ($item){

        return  strftime("%d-%m-%Y",strtotime($item['created_at'])) <=\request()->header('date_to');
    });

}
return response()->json([
    'code'=>200,
    'message'=>'success',
    'data'=>$transactions
]);
//
//        $logs=User::where('id',\request()->header('user_id'))->with(['transactions'=>function($q){
//            $q->select(['name_'.\request()->header('lang').' as name'])->where('transactions.id',\request()->header('transaction_id'))->get();
//        }])->get();
//        return $logs;

    }
}
