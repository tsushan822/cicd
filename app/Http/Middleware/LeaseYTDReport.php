<?php

namespace App\Http\Middleware;

use App\Zen\System\Service\ModuleAvailabilityService;
use Closure;

class LeaseYTDReport
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
        if(ModuleAvailabilityService ::checkYTDReportAvailability())
            return $next($request);
        abort(404);

    }
}
