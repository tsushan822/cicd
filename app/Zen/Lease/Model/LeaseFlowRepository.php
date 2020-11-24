<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/04/2018
 * Time: 14.56
 */

namespace App\Zen\Lease\Model;


use App\Repository\Eloquent\Repository;
use App\Scopes\LeaseAccountableScope;
use App\Zen\Bookkeeping\Model\Account;
use App\Zen\Lease\Calculate\Generate\GenerateLeaseFlow;
use App\Zen\Lease\Calculate\Generate\StoreGeneratedLeaseFlow;
use Illuminate\Support\Facades\Auth;

class LeaseFlowRepository extends Repository
{

    /**
     * Specify Model class name
     * @return mixed
     */
    public function model()
    {
        return LeaseFlow::class;
    }

    public function getGenerateView()
    {
        return $payments = [
            '12 months' => '1 per Year',
            '6 months' => '2 per Year',
            '4 months' => '3 per Year',
            '3 months' => '4 per Year',
            '2 months' => '6 per Year',
            '1 month' => '12 per Year',
        ];
    }

    /**
     * @param $request
     * @return array
     */
    public function getGeneratedData($request)
    {
        list($paymentDates, $lease, $startDate, $fees) =
            GenerateLeaseFlow ::generateLeaseFlow($request);
        return array($paymentDates, $lease, $startDate, $fees);

    }

    public function storeGeneratedPostData($request)
    {
        $leaseId = $request -> lease;
        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);
        $leaseId = (new StoreGeneratedLeaseFlow($lease)) -> storeGeneratedLeaseFlow($request);
        return $leaseId;
    }

    public function handleEdit($request, $id)
    {
        $leaseFlow = $this -> findOrFail($id);
        $extraArray = ['updated_user_id' => Auth ::id()] + ['total_payment' => $request -> fees + $request -> fixed_payment];
        $leaseFlow -> update($request -> all() + $extraArray);
    }

    public function getCreateViewData($leaseId)
    {
        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);
        $accounts = Account ::get() -> pluck('account_name', 'id');
        return array($lease, $accounts);
    }

    public function handleCreate($request)
    {
        $request -> request -> add(['user_id' => Auth ::id()]);
        return $this -> create($request -> all());
    }

}