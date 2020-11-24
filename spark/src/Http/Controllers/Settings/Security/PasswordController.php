<?php

namespace Laravel\Spark\Http\Controllers\Settings\Security;

use App\Rules\PasswordRule;
use App\Zen\Setting\Model\AdminSetting;
use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Spark\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting) {
            if(!is_null($adminSetting -> min_password_length))
                config(['password_validation.min_length' => $adminSetting -> min_password_length]);

            if(!is_null($adminSetting -> max_password_length))
                config(['password_validation.max_length' => $adminSetting -> max_password_length]);
        }
        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'string', 'confirmed', 'min :' . config('password_validation.min_length'), 'max :' . config('password_validation.max_length'), new PasswordRule()],
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return response()->json([
                'errors' => [
                    'current_password' => [__('The given password does not match our records.')]
                ]
            ], 422);
        }

        $request->user()->forceFill([
            'password' => Hash::make($request->password)
        ])->save();
    }
}
