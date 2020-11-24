<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 23/10/2017
 * Time: 13.12
 */

namespace App\Zen\User\Model;


class RoleRepository
{
    public function __construct()
    {
    }

    public function getPermissionOfAllRoles()
    {
        $permissions = Permission ::with('roles') -> whereNotIn('name', config('zenlease.roles.hidden_permissions')) -> orderBy('name') -> get();
        $rolesArray = Role ::all() -> pluck('id');
        foreach($permissions as $permission) {
            $perm_role = [];
            foreach($permission -> roles as $role) {
                array_push($perm_role, $role -> id);
            }
            foreach($rolesArray as $item) {
                if(in_array($item, $perm_role))
                    $permission[$item] = 1;
                else
                    $permission[$item] = 0;
            }
        }
        return $permissions;
    }
}