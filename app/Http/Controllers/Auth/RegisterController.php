<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\PasswordRule;
use App\Zen\Setting\Model\AdminSetting;
use App\Zen\System\Model\Customer;
use App\Zen\System\Service\CustomSparkRegister;
use App\Zen\System\Service\RegisterService;
use App\Zen\User\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest;
use Laravel\Spark\Contracts\Interactions\Auth\Register;
use Laravel\Spark\Spark;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/spark';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this -> middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting) {
            if(!is_null($adminSetting -> min_password_length))
                config(['password_validation.min_length' => $adminSetting -> min_password_length]);

            if(!is_null($adminSetting -> max_password_length))
                config(['password_validation.max_length' => $adminSetting -> max_password_length]);
        }
        return Validator ::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenant.users',
            'password' => ['required', 'string', 'confirmed', 'min :' . config('password_validation.min_length'), 'max :' . config('password_validation.max_length'), new PasswordRule()],
        ]);
    }


    protected function create(array $data)
    {
        return User ::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function createCompany(RegisterRequest $request)
    {
        if($request -> input('invitation')) {
            $this -> createUser($request);
            return response() -> json(['redirect' => '/main']);
        }

        list($token, $url, $user, $customer) = (new RegisterService) -> registerNewCustomer($request);


        (new CustomSparkRegister($customer -> team)) -> subscribe($request, $user);

        $this -> redirectTo = 'http://' . $url . '/setup?token=' . $token . '&user_id=' . $user -> id . '&customer_id=' . $customer -> id;

        return response() -> json([
            'redirect' => $this -> redirectPath()
        ]);
    }

    protected function createUser($request)
    {
        $customer = Customer ::where('website_id', app('websiteId')) -> first();
        $attr = [
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request -> password),
            'current_team_id' => $customer -> team_id,
            'is_owner' => 0,
        ];
        return User ::create($attr);
    }
}