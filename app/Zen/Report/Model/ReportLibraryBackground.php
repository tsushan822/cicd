<?php

namespace App\Zen\Report\Model;

use App\Zen\User\Model\BaseModel;

class ReportLibraryBackground extends BaseModel
{
    protected $fillable = ['user_id', 'report_libraries', 'remarks','attempts', 'done', 'file_format',
        'start_date', 'end_date', 'start_time', 'end_time'];
}
