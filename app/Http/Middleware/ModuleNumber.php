<?php

namespace App\Http\Middleware;


use App\Zen\System\Model\Customer;
use App\Zen\System\Model\Module;
use App\Zen\System\Service\ModuleAvailabilityService;
use Closure;

class ModuleNumber
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $moduleName
     * @return mixed
     */
    public function handle($request, Closure $next, $moduleName = null)
    {
        if(class_exists(app('websiteId'))) {
            if(!ModuleAvailabilityService ::availabilityCount($moduleName)) {
                $customer = Customer :: where('website_id', app('websiteId')) -> first();
                $module = Module ::where('name', $moduleName) -> where('customer_id', $customer -> id) -> first();
                flash('Your plan doesn\'t allow you to add more than ' . $module -> available_number . ' ' . $moduleName) -> overlay();
                return redirect('/main');
            }
        }

        return $next($request);
    }

}
