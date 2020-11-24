<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws CustomException
     */
    public function handle($request, Closure $next)
    {
        if(auth()->check() && auth()->user()->hasRole('admin'))
            return $next($request);

        flash(trans('Sorry! User has no access to this page.'))->overlay();
        return redirect('/home');
    }
}
