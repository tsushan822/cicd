<?php

namespace App\Http\Middleware;

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Closure;

class SetupComplete
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
        if((!$this->CurrencySetup() || !$this->LessorSetup() || !$this->LeaseTypeSetup()) && env('MANDATORY_SETUP') ){
            return redirect('/setup');
        }
        else{
            return $next($request);

        }
    }

    private function CurrencySetup(){
        if(Currency::where('active_status','=','1')->count() > 0){
            return true;
        }
        return false;
    }

    private function LessorSetup(){
        if(Counterparty::where('is_parent_company','!=','1')->count() > 0){
            return true;
        }
        return false;
    }

    private function LeaseTypeSetup(){
        if(LeaseType::count() > 0){
            return true;
        }
        return false;
    }

}
