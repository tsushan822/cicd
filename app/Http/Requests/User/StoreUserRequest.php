<?php

namespace App\Http\Requests\User;

use App\Rules\PasswordRule;
use App\Rules\User\UserEmailDomain;
use App\Rules\User\UserPhoneNumber;
use App\Zen\Setting\Model\AdminSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest;

class StoreUserRequest extends FormRequest implements RegisterRequest
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $adminSetting = AdminSetting ::first();
        if($adminSetting instanceof AdminSetting) {
            if(!is_null($adminSetting -> min_password_length))
                config(['password_validation.min_length' => $adminSetting -> min_password_length]);

            if(!is_null($adminSetting -> max_password_length))
                config(['password_validation.max_length' => $adminSetting -> max_password_length]);
        }

        $phone_number_validation = $this -> checkIfTwoFactorOff(Request ::get('two_factor_type'));

        if(is_numeric(request() -> segment(2))) {
            $returnArray = [
                'lease_maturing_notify_prior_days' => 'numeric|between:1,365',
                'name' => 'required',
                'dialing_code' => 'required_unless:two_factor_type,off|in:' . implode(',', array_keys(config('twofactor.dialing_codes'))),
                'phone_number' => $phone_number_validation
            ];
        } else {
            $returnArray = [
                'name' => 'required',
                'dialing_code' => 'required_unless:two_factor_type,off|in:' . implode(',', array_keys(config('twofactor.dialing_codes'))),
                'email' => ['required', 'email', 'unique:tenant.users', new UserEmailDomain],
                //'password' => [ 'string', 'confirmed', 'min :' . config('password_validation.min_length'), 'max :' . config('password_validation.max_length'), new PasswordRule()],
                'phone_number' => $phone_number_validation,
                'role' => 'required',
                'counterparty' =>'required' ,
            ];

        }
        return $returnArray;
    }

    public function messages()
    {
        return [
            'phone_number.regex' => 'Please enter the phone number without the first 0 or country code prefix.',
            'counterparty.required' => 'Please assign one or more companies to the user.',
        ];
    }

    protected function checkIfTwoFactorOff($two_factor_type)
    {
        // this could be a switch or any conditional logic and then based on condition return string
        return ($two_factor_type !== 'off') ? ['required_unless:two_factor_type,off', 'regex:/^[1-9]{1}/', 'min:9', 'numeric', (new UserPhoneNumber($this -> route('user')))] : ['nullable', (new UserPhoneNumber($this -> route('user')))];
    }

}
