<?php

namespace App\Http\Middleware;

use App\Zen\System\Service\ModuleAvailabilityService;
use Closure;

class FacilityOverviewReport
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
        if(ModuleAvailabilityService ::checkFacilityOverviewReportAvailability())
            return $next($request);

        abort(404);

    }
}
