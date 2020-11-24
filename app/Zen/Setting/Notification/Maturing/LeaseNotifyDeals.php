<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 14/06/2018
 * Time: 14.39
 */

namespace App\Zen\Setting\Notification\Maturing;


use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Model\MaturingNotification;
use Illuminate\Support\Carbon;

class LeaseNotifyDeals extends MaturingNotifyDeals
{
    public function getLeases($user, $priorDays)
    {
        $leases = $this -> getDeals(Lease::class, $user, $priorDays, 'contractual_end_date');
        return $leases;
    }
}