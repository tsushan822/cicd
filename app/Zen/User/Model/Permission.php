<?php

namespace App\Zen\User\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'label'];

    public function roles()
    {
        return $this -> belongsToMany(Role::class);
    }

}
