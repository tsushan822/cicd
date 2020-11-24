<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 29/03/2018
 * Time: 12.43
 */

namespace App\Zen\Setting\Notification\Maturing;

use App\Notifications\MailableNotification;
use App\Zen\Setting\Model\MaturingNotification;
use App\Zen\System\Traits\ConfigDatabase;

class EmailMaturingDeals
{
    use ConfigDatabase;
    private $websiteId;

    public function sendNotification()
    {
        $maturingNotificationUsers = static ::getUser();
        foreach($maturingNotificationUsers as $user) {
            $returnDeals['leases'] = null;
            $maturingNotifications = MaturingNotification ::with('user') -> where('active_status', 1) -> where('user_id', $user) -> get();

            foreach($maturingNotifications as $maturingNotification) {
                if($maturingNotification -> type == 'lease_maturing_notify')
                    $returnDeals['leases'] = (new LeaseNotifyDeals()) -> getLeases($maturingNotification -> user, $maturingNotification -> prior_days);

            }
            if(isset($maturingNotification) && $maturingNotification instanceof MaturingNotification)
                $this -> sendEmail($returnDeals, $maturingNotification -> user);
        }

    }

    public function getUser()
    {
        $maturingNotifications = MaturingNotification :: whereHas('user', function ($query) {
            $query -> where('active_status', 1);
        }) -> distinct('user_id') -> where('active_status', 1) -> pluck('user_id');
        return $maturingNotifications;
    }

    public function sendEmail($allDeals, $user)
    {
        if($allDeals['leases']) {
            $user -> notify(new MailableNotification($allDeals, $user, $this -> websiteId));
        }
    }

    /**
     * @param mixed $websiteId
     * @return EmailMaturingDeals
     */
    public function setWebsiteId($websiteId)
    {
        $this -> websiteId = $websiteId;
        return $this;
    }
}