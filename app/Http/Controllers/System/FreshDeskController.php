<?php

namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class FreshDeskController extends Controller
{


    public function sso(Request $request)
    {
        $name=$request->cookie('freshdesh_a');
        $email=$request->cookie('freshdesh_e');
        $privateKey = config('rsa_key.private');
        $payload = array(
            "sub" => $name,
            "email" => $email,
            "iat" => Carbon::now()->addMinutes(2)->timestamp,
            "nonce" => $request->nonce,
            "given_name" => $name,
            "family_name" => ''
        );
        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        return redirect($request->redirect_uri . '?state=' . $request->state . '&id_token=' . $jwt);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setUserNameCookie(Request $request)
    {
        if(Auth::user()){
            $cookieLifetime = time() + 60 * 60 * 24 * 365;
            Cookie::queue(Cookie::make('freshdesh_a', Auth::user()->name, $cookieLifetime,null,'.'.env('SERVER_URL')));
            Cookie::queue(Cookie::make('freshdesh_e', Auth::user()->email, $cookieLifetime,null,'.'.env('SERVER_URL')));
        }
        return view('Pages.redirect_to_freshdesk');
    }

 }