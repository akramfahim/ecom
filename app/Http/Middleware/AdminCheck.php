<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->path() == 'app/login_admin'){
            return $next($request);
        }
        if(!Auth::check()){
            return response()->json([
                'msg' => 'You are not allowed to Access This Page',
                'url' => $request->path()
            ],403);
        }
        $user = Auth::user();
        if($user->userType == 'user'){
            return response()->json([
                'msg' => 'You are not allowed to access this page'
            ],403);
        }
        return $next($request);
    }
}
