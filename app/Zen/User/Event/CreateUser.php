<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/09/2018
 * Time: 12.07
 */

namespace App\Zen\User\Event;


use App\Zen\Setting\Model\Dashboard;

trait CreateUser
{
    protected static function bootCreateUser()
    {
        /*static ::created(function ($model) {
            $arrayValue = [1, 2, 3, 4];
            foreach($arrayValue as $item) {
                $dashboard = Dashboard ::find($item);
                $dashboard -> users() -> attach([$model -> id => ['active_status' => 1]]);
            }
        });*/
    }
}