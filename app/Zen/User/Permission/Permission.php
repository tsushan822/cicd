<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 17/11/2017
 * Time: 8.51
 */

namespace App\Zen\User\Permission;


use App\Exceptions\CustomException;
use Exception;
use Illuminate\Support\Facades\Gate;


trait Permission
{
    function checkAllowAccess($permission)
    {
        if(Gate::denies($permission))
        {
            throw new CustomException(trans('master.You do not have the required authorization'));
        }
        return true;
    }

    function checkAllowAccessWithoutException($permission)
    {

        if(Gate::denies($permission))
        {
            return false;
        }
        return true;
    }
}