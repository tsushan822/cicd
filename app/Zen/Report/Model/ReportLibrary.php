<?php

namespace App\Zen\Report\Model;

use App\Zen\System\Model\Module;
use App\Zen\User\Model\BaseModel;
use App\Zen\User\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportLibrary extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['module_id', 'user_id', 'criteria', 'report_name', 'custom_report_name', 'route'];

    protected function module()
    {
        return $this -> belongsTo(Module::class);
    }

    protected function user()
    {
        return $this -> belongsTo(User::class);
    }
}
