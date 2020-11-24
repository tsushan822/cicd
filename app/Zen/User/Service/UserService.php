<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 19/03/2019
 * Time: 15.01
 */

namespace App\Zen\User\Service;

use App\Facades\Authy;
use App\Services\Authy\Exceptions\RegistrationFailedException;
use App\Zen\User\Model\User;
use Authy\AuthyApi;

class UserService
{
    public static function registerAuthy(User $user)
    {
        if(!$user -> registeredForTwoFactorAuthentication() && $user -> two_factor_type == 'app') {
            try {
                $authy_api = new AuthyApi(config('twofactor.API_KEY'));
                $userAdd = $authy_api -> registerUser($user -> email, $user -> phone_number, $user -> dialing_code);
                if($userAdd -> ok()) {
                    $user -> authy_id = $userAdd -> id();
                    $user -> save();
                    flash() -> info(trans('master.The authentication has been added to the database'), trans('master.Success'));
                }
            } catch (RegistrationFailedException $e) {
                flash() -> info($e -> getMessage());
            }
        }
    }
}