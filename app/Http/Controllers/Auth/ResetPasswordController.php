<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RestrictLoginInApp;
use App\Rules\PasswordRule;
use App\Zen\Setting\Model\AdminSetting;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this -> middleware('guest');
    }

    public function rules()
    {
        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting) {
            if(!is_null($adminSetting -> min_password_length))
                config(['password_validation.min_length' => $adminSetting -> min_password_length]);

            if(!is_null($adminSetting -> max_password_length))
                config(['password_validation.max_length' => $adminSetting -> max_password_length]);
        }

        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'confirmed', 'min :' . config('password_validation.min_length'), 'max :' . config('password_validation.max_length'), new PasswordRule()],
        ];
    }

    /**
     * Reset the given user's password.
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user -> password = Hash ::make($password);

        $user -> setRememberToken(Str ::random(60));

        $user -> must_change_password = 0;

        $user -> password_changed_at = now();

        $user -> save();

        event(new PasswordReset($user));
    }
}
