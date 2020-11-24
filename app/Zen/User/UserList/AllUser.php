<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/02/2018
 * Time: 10.45
 */

namespace App\Zen\User\UserList;


use App\Zen\User\Model\User;
use Illuminate\Support\Facades\DB;

trait AllUser
{
    public function getAllUsersWithGivenLabel($label)
    {
        $users = User::whereHas('roles', function ($q) use ($label) {
            $q->where('roles.name', $label);
        })->get();
        return $users;
    }

    public function getUserFirst($label)
    {
        $user = DB ::table('users') -> join('role_user', 'users.id', '=', 'role_user.user_id')
            -> join('roles', 'roles.id', '=', 'role_user.role_id')
            -> where('roles.name', $label) -> first();
        return $user;
    }
}