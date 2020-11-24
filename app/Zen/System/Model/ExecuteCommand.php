<?php

namespace App\Zen\System\Model;

use Illuminate\Database\Eloquent\Model;

class ExecuteCommand extends Model
{
    protected $table = 'execute_commands';

    protected $fillable = ['customer_id','command_type','date_to_run','started_at','ended_at','done'];
}
