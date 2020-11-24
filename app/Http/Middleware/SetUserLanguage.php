<?php

namespace App\Http\Middleware;


use Session;
use Closure;
use App;
use Auth;

class SetUserLanguage
{


    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            App::setLocale(Auth::user()->locale);


            switch (Auth::user()->locale) {
                case "fi":
                    setlocale(LC_TIME, 'fi_FI.utf8');
                    break;
                case "sv":
                    setlocale(LC_TIME, 'sv_SV.utf8');
                    break;
                case "de":
                    setlocale(LC_TIME, 'de_DE.utf8');
                    break;
                case "fr":
                    setlocale(LC_TIME, 'fr_FR.utf8');
                    break;
                default:
                    setlocale(LC_TIME, 'en');
            }


        } elseif ($locale = Session::has('locale')) {
            App::setLocale($locale);
        }


        return $next($request);
    }
}
