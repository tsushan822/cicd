<?php

namespace App\Zen\Client\Model;

use Illuminate\Database\Eloquent\Model;

class ImportFile extends Model
{
    protected $table = 'import_files';

    protected $fillable = ['user_id', 'file_name', 'start_time', 'end_time'];
}
