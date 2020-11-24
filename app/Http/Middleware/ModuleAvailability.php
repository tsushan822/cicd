<?php

namespace App\Http\Middleware;

use App\Zen\System\Model\Customer;
use App\Zen\System\Model\Module;
use Closure;
use Hyn\Tenancy\Models\Website;

class ModuleAvailability
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $module
     * @return mixed
     */
    public function handle($request, Closure $next, $module = null)
    {
        if($module && class_exists(app('websiteId'))) {
            $customer = Customer :: where('website_id', app('websiteId')) -> first();
            $availability = Module ::where('name', $module) -> where('customer_id', $customer -> id) -> first();
            if(($availability instanceof Module) && $availability -> available == 0) {
                flash($module . ' module is not available.') -> overlay();
                return redirect('/main');
            }
        }
        return $next($request);
    }
}
