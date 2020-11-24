<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;

class Dashboard extends BaseModel
{
    protected $fillable = ['name', 'item', 'module_id'];

    public function users()
    {
        return $this -> belongsToMany(User::class, 'dashboard_user');
    }

    public function attachUser($user)
    {
        if(is_object($user)) {
            $user = $user -> getKey();
            $this -> users() -> attach($user);
        } elseif(is_array($user)) {
            foreach($user as $perm) {
                $this -> users() -> attach($perm);
            }
        } else {
            $this -> users() -> attach($user);
        }
    }
}
