<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 14/02/2019
 * Time: 13.43
 */

namespace App\Zen\Setting\Traits;

use App\Exceptions\CustomException;
use App\Zen\System\Model\Module;

trait GetModuleId
{
    public function getModuleId($name)
    {
        $module = Module ::where('name', $name) -> first();
        if(!$module instanceof Module)
            throw new CustomException(trans('master.Sorry, there is some problem, contact system administrator'));
        return $module -> id;
    }
}