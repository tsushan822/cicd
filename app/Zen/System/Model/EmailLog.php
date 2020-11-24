<?php

namespace App\Zen\System\Model;

class EmailLog extends SystemModel
{
    protected $fillable = ['website_id', 'message', 'header', 'subject', 'sending_at','user_id'];
}
