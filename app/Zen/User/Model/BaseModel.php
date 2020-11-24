<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 20/11/2017
 * Time: 9.23
 */

namespace App\Zen\User\Model;

use App\Zen\User\Permission\AllowedEntity;
use Hyn\Tenancy\Abstracts\TenantModel as Model;

class BaseModel extends Model
{
    use AllowedEntity;
    //protected $connection = 'tenant';
    public function createdByUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class,'updated_user_id');
    }
}