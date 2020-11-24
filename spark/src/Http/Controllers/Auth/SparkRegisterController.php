<?php

namespace Laravel\Spark\Http\Controllers\Auth;

use App\Zen\System\Service\FqdnService;
use App\Zen\System\Service\RegisterService;
use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Events\Auth\UserRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Spark\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Laravel\Spark\Contracts\Interactions\Auth\Register;
use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest;

class SparkRegisterController extends Controller
{
    use RedirectsUsers;
    use FqdnService;

    /**
     * Where to redirect users after registration.
     * @var string
     */
    protected $redirectTo = '/main';

    /**
     * Create a new authentication controller instance.
     * @return void
     */
    public function __construct()
    {
        $this -> middleware('guest');

        $this -> redirectTo = Spark ::afterLoginRedirect();
    }

    /**
     * Show the application registration form.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        if(Spark ::promotion() && !$request -> filled('coupon')) {
            // If the application is running a site-wide promotion, we will redirect the user
            // to a register URL that contains the promotional coupon ID, which will force
            // all new registrations to use this coupon when creating the subscriptions.
            return redirect($request -> fullUrlWithQuery([
                'coupon' => Spark ::promotion()
            ]));
        }

        return view('spark::auth.register');
    }

    /**
     * Handle a registration request for the application.
     * @param \Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {

        list($user, $paymentId) = Spark ::interact(
            Register::class, [$request]
        );

        Auth ::login($user);

        event(new UserRegistered($user));

        if($request -> input('invitation')) {
            return response() -> json(['redirect' => '/main']);
        }

        if($user instanceof MustVerifyEmail && !$user -> hasVerifiedEmail()) {
            $user -> sendEmailVerificationNotification();
        }

        list($token, $url, $user, $customer) = (new RegisterService) -> registerNewCustomer($request);

        $this -> redirectTo = 'http://' . $url . '/setup?token=' . $token . '&user_id=' . $user -> id;
        Auth ::logout();

        return response() -> json([
            'redirect' => $this -> redirectPath()
        ]);
    }
}
