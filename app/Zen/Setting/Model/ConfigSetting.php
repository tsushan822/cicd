<?php
 namespace App\Zen\Setting\Model;

use App\Zen\User\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigSetting extends BaseModel
{
    use SoftDeletes;
}
