<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;

class MaturingNotification extends BaseModel
{
    protected $fillable = ['user_id','prior_days','type','table_name','column_name','active_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
