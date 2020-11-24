<?php

namespace App\Zen\User\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'label'];

    public function permissions()
    {
        return $this -> belongsToMany(Permission::class);
    }

    public function assign(Permission $permission)
    {
        return $this -> permissions() -> save($permission);
    }

    public function attachPermission($permission)
    {
        if(is_object($permission)) {
            $permission = $permission -> getKey();
            $this -> permissions() -> attach($permission);
        } elseif(is_array($permission)) {
            foreach($permission as $perm) {
                $this -> permissions() -> attach($perm);
            }

        } else {
            $this -> permissions() -> attach($permission);
        }
    }

    public function users()
    {
        return $this -> belongsToMany(User::class);
    }

}
