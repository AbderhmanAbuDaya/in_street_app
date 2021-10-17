<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user->type != 'admin') {
            return response()->json([
                'code' => 403,
                'message' => 'You are not Admin',
            ]);
        }
        return $next($request);
    }
}
