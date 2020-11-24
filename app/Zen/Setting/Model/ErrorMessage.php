<?php

namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;

class ErrorMessage extends BaseModel
{
    protected $table = 'errors_informartion';
    protected $fillable = ['module','user_id','has_read','error_message_custom','error_message', 'error_code', 'source'];
}
