<?php

namespace App\Http\Middleware;

use App\Models\Drive;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsDriver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            $user=Auth::user();
            $drive=$user->drive()->first();
            if (!$drive ||$drive->statusType->name_en=='deny')
                return response()->json([
                    'code'=>'403',
                    'message'=>'unAuthorization because you not driver',
                ]);
        }
        return $next($request);
    }
}
