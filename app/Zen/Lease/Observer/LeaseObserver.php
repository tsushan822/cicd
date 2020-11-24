<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 08/03/2019
 * Time: 16.21
 */

namespace App\Zen\Lease\Observer;

use App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB\UpdateLeasePaymentDay;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use Illuminate\Support\Facades\DB;

class LeaseObserver
{
    /**
     * Listen to the User created event.
     * @param Lease $lease
     * @return void
     */
    public function created(Lease $lease)
    {
        //
    }

    /**
     * Listen to the User created event.
     * @param Lease $lease
     * @return void
     */
    public function updated(Lease $lease)
    {
        if($lease -> isDirty('payment_day')) {
            UpdateLeasePaymentDay ::updatePaymentDay($lease);
        }

        if($lease -> isDirty('cost_center_split')) {
            if($lease -> cost_center_split == false) {
                $lease -> costCenters() -> detach();
            }

            if($lease -> cost_center_split == true) {
                DB ::table('leases') -> where('id', $lease -> id) -> update(['cost_center_id' => null]);
            }
        }
    }

    /**
     * Listen to the User deleting event.
     * @param Lease $lease
     * @return void
     */
    public function deleting(Lease $lease)
    {
        foreach($lease -> leaseFlow() -> get() as $leaseFlow) {
            $leaseFlow -> delete();
        }
        $deletedLeaseExtensions = LeaseExtension ::where('lease_id', $lease -> id) -> delete();
    }
}