<?php

namespace App\Http\Controllers\Auth;

use App\Http\Middleware\RestrictLoginInApp;
use App\Rules\User\MustChangePassword;
use App\Rules\User\PasswordExpiration;
use App\Zen\Setting\Model\AdminSetting;
use App\Zen\User\Model\User;
use App\Http\Controllers\Controller;
use App\Rules\User\DataPresent;
use App\Rules\User\UserVerified;
use Hyn\Tenancy\Facades\TenancyFacade;
use Hyn\Tenancy\Models\Website;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Set how many failed logins are allowed before being locked out.
     */
    public $maxAttempts = 5;


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected $redirectTo = '/main';

    protected $redirectToToken = '/auth/token';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this -> middleware('guest') -> except('logout');
        $this -> middleware(RestrictLoginInApp::class) -> only('showLoginForm');
        $this -> maxAttempts = config('password_validation.number_of_unsuccessful_login');

        //Tenancy check because its throwing database 'tenant' error
        $website = TenancyFacade ::website();
        if($website instanceof Website) {
            $adminSetting = AdminSetting ::first();
            if($adminSetting instanceof AdminSetting && $adminSetting -> number_of_unsuccessful_login) {
                $this -> maxAttempts = $adminSetting -> number_of_unsuccessful_login;
                config(['password_validation.enable_failed_login_lock' => $adminSetting -> enable_failed_login_lock]);
            }
        }
    }


    public function showLoginForm()
    {
        $email = request() -> has('email') ? request() -> input('email') : null;
        return view('auth.login', compact('email'));
    }

    /**
     * Handle a login request to the application.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this -> validateLogin($request);

        $mustChangePassword = (new MustChangePassword($request -> email)) -> passes('email', $request -> email);

        if($mustChangePassword) {
            return redirect() -> route('password.request') -> with('status', 'You need to reset your password first.');
        }


        list($passwordExpiration, $message) = (new PasswordExpiration($request -> email)) -> getResult('email', $request -> email);

        if($passwordExpiration) {
            return redirect() -> route('password.request') -> with('status', $message);
        }


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if($this -> hasTooManyLoginAttempts($request)) {
            $this -> fireLockoutEvent($request);

            //return $this -> sendLockoutResponse();
        }


        if($this -> attemptLogin($request)) {
            return $this -> sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this -> incrementLoginAttempts($request);


        return $this -> sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this -> validate($request, [
            'email' => ['bail', new DataPresent, new UserVerified, 'email', 'required'],
            'password' => 'required',
        ]);
    }

    public function attemptLogin(Request $request)
    {

        return $this -> guard() -> attempt(
            ['verified' => 1] + ['active_status' => 1] + $this -> credentials($request), $request -> has('remember')
        );
    }

    public function logout(Request $request)
    {
        Auth ::logout();
        return redirect('/login');
    }


    protected function logoutAndRedirectToTokenEntry(Request $request, User $user)
    {
        Auth ::logout();

        $request -> session() -> put('authy', [
            'user_id' => $user -> id,
            'authy_id' => $user -> authy_id,
            'using_sms' => false,
            'remember' => $request -> has('remember'),
        ]);

        return redirect($this -> redirectTokenPath());
    }

    protected function redirectTokenPath()
    {
        return $this -> redirectToToken;
    }


    public function redirectTo()
    {
        return '/main';
    }

}
