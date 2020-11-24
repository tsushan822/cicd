<?php

namespace App\Http\Controllers;

use App\Zen\Setting\Convention\BusinessDayConvention\DateTimeConversion;
use App\Zen\Setting\Traits\ReportValidation;
use App\Zen\User\Permission\AllowedEntity;
use App\Zen\User\Permission\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Permission, DateTimeConversion, ReportValidation, AllowedEntity;

    public function meta($title = '', $description = '')
    {
        return [
            'description' => $description,
            'title' => $title
        ];
    }
}
