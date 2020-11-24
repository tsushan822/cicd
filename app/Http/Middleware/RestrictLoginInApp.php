<?php

namespace App\Http\Middleware;

use Closure;

class RestrictLoginInApp
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subDomain = explode('.', request() -> getHost());
        if($subDomain[0] == 'app'){
            return redirect() -> route('login_initial');
        }


        return $next($request);
    }
}
