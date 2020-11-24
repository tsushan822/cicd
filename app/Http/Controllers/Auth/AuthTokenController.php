<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Authy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Authy\Exceptions\InvalidTokenException;
use Illuminate\Support\Facades\Auth;


class AuthTokenController extends Controller
{

    public function getToken(Request $request)
    {

        if(!$request -> session() -> has('authy')) {
            return redirect() -> to('/');
        }
        return view('auth.token');

    }

    public function postToken(Request $request)
    {

        $this -> validate($request, ['token' => 'required|digits_between:6,10']);

        try {
            $verification = Authy ::verifyToken($request -> token);
        } catch (InvalidTokenException $e) {
            return redirect() -> back() -> withErrors(['token' => 'Invalid token',]);
        }

        if(Auth ::loginUsingId($request -> session() -> get('authy.user_id'), $request -> session() -> get('authy.remember'))) {
            $request -> session() -> forget('authy');
            return redirect() -> intended();
        }

        return redirect() -> url('/');
    }
}
