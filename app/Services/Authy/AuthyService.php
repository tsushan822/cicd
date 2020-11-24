<?php
/**
 * Created by PhpStorm.
 * User: Lasse
 * Date: 17/02/2019
 * Time: 11.20
 */

namespace App\Services\Authy;

use App\Zen\User\Model\User;
use Authy\AuthyApi;

use App\Services\Authy\Exceptions\InvalidTokenException;
use App\Services\Authy\Exceptions\RegistrationFailedException;
use App\Services\Authy\Exceptions\SmsRequestFailedException;

class AuthyService
{
    private $client;

    public function __construct(AuthyApi $client)
    {
        $this->client=$client;
    }

    public function registerUser(User $user)
    {

        //register users authy accounts with LeaseAccounting
        $user = $this->client->registerUser(
            $user->email,
            $user->phone_number,
            $user->dialing_code);

        if (!$user->ok()) {

            throw new RegistrationFailedException;
        }
        return $user->id();

    }

    public function verifyToken($token, User $user = null)
    {

        //signing user out and then in after authy ok

        try{
        $verification=$this->client->verifyToken(
            $user ? $user ->authy_id:request()->session()->get('authy.authy_id'),
            $token
        );
    } catch(AuthyFormatException $e) {
            throw new InvalidTokenException;
        }
        if (!$verification->ok()){
            throw new InvalidTokenException;
        }
        return true;
    }

    public function requestSms(User $user)
    {
        $request= $this->client->requestSms($user->authy_id,[
            'force'=>false,
        ]);
        if(!$request->ok()){
            throw new SmsRequestFailedException;
        }
    }

}