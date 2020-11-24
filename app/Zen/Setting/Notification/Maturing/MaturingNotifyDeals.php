<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 29/03/2018
 * Time: 11.12
 */

namespace App\Zen\Setting\Notification\Maturing;


use App\Zen\Setting\Model\MaturingNotification;
use App\Zen\User\Model\User;
use Carbon\Carbon;

abstract class MaturingNotifyDeals
{
    public function getDeals($model, $user, $priorDays, $maturityColumn = 'maturity_date')
    {
        $maturingDate = Carbon ::today() -> addDays($priorDays) -> toDateString();
        $deals = $model ::where($maturityColumn, $maturingDate) -> refactorEntity($user) -> get();
        if(count($deals))
            return $deals;
        return null;

    }

}