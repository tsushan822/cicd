<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Token;

class AuthToken
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request -> input('token')) {
            if($request -> input('user_id') && $request -> isMethod('GET')) {
                $token = Token ::where('user_id', $request -> input('user_id'))->where('customer_id',$request -> input('customer_id')) -> where('expires_at', '>', now()) -> first();
                if($token -> token == $request -> input('token')) {
                    Auth ::loginUsingId($request -> input('user_id'));
                    return redirect()->route('dashboard.lease');
                }
            }
            abort(404);
        }
        if(auth() -> user()) {
            return $next($request);
        }
        abort(404);
    }
}
