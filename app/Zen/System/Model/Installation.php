<?php

namespace App\Zen\System\Model;


class Installation extends SystemModel
{
    protected $fillable = ['customer_id', 'module_id', 'quantity'];
}
