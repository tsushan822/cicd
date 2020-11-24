<?php


namespace App\Zen\User\Service;

use App\Zen\User\Model\User;

class AddUser
{

    public function addUser($userDetails = [])
    {
        $user = User ::create($userDetails);
        if(isset($userDetails['role']))
            $user -> assign($userDetails['role']);

    }
}