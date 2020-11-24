<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/04/2018
 * Time: 10.24
 */

namespace App\Zen\User\NotificationSetting;


use App\Zen\Setting\Model\MaturingNotification;

class DatabaseToFormArray
{
    public static function maturingNotificationDays($userId)
    {
        $returnArray = [];
        $maturingNotifications = MaturingNotification ::where('user_id', $userId) -> get();
        $returnArray['lease_maturing_notify'] = 0;
        $returnArray['lease_maturing_notify_prior_days'] = 3;

        foreach($maturingNotifications as $maturingNotification) {

            if($maturingNotification -> type == 'lease_maturing_notify') {
                $returnArray['lease_maturing_notify'] = $maturingNotification -> active_status;
                $returnArray['lease_maturing_notify_prior_days'] = $maturingNotification -> prior_days;
            }
        }
        return $returnArray;
    }
}