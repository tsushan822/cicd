<?php

namespace App\Zen\User\Model;

class FailedLoginAttempt extends BaseModel
{
    protected $fillable = [
        'user_id', 'email_address', 'ip_address',
    ];

    public static function record($email, $ip, $user = null)
    {
        return static ::create([
            'user_id' => is_null($user) ? null : $user -> id,
            'email_address' => $email,
            'ip_address' => $ip,
        ]);
    }
}
