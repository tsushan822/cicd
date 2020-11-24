<?php

namespace App\Http\Controllers\Lease;

use App\Events\Lease\ClearAll;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lease\GenerateLeaseFlowRequest;
use App\Http\Requests\Lease\StoreLeaseFlowRequest;
use App\Scopes\LeaseAccountableScope;
use App\Zen\Setting\Model\Account;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use Illuminate\Http\Request;
use App\Zen\Lease\Model\LeaseFlowRepository as LeaseFlowRepo;

class LeaseFlowController extends Controller
{
    /**
     * @var LeaseFlowRepo
     */
    private $leaseFlowRepo;

    /**
     * LeaseFlowController constructor.
     * @param LeaseFlowRepo $leaseFlowRepo
     */
    public function __construct(LeaseFlowRepo $leaseFlowRepo)
    {
        $this -> leaseFlowRepo = $leaseFlowRepo;
    }

    /**
     * Show the form for creating a new resource.
     * @param $leaseId
     * @return \Illuminate\Http\Response
     */
    public function create($leaseId)
    {
        $this -> checkAllowAccess('create_lease_flow');
        list($lease, $accounts) = $this -> leaseFlowRepo -> getCreateViewData($leaseId);
        return view('Lease.lease-flows.create', compact('lease', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreLeaseFlowRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeaseFlowRequest $request)
    {
        $this -> checkAllowAccess('create_lease_flow');
        flash() -> overlay(trans('master.LeaseFlow has been created!'), trans('master.Success!')) -> message();
        $leaseFlow = $this -> leaseFlowRepo -> handleCreate($request);
        return redirect() -> route('leases.edit', $leaseFlow -> lease_id);

    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this -> checkAllowAccess('view_lease_flow');
        $leaseFlow = $this -> leaseFlowRepo -> findOrFail($id);
        return view('Lease.lease-flows.delete', compact('leaseFlow'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disableFixAmount = false;
        $this -> checkAllowAccess('can_view');
        $leaseFlow = $this -> leaseFlowRepo -> findOrFail($id);
        $lease = $leaseFlow -> lease;
        $numberOfExtensions = $lease -> leaseExtension -> count();
        if($numberOfExtensions > 1)
            $disableFixAmount = true;
        $accounts = Account ::get() -> pluck('account_name', 'id');
        return view('Lease.lease-flows.edit', compact('leaseFlow', 'accounts', 'lease', 'disableFixAmount'));
    }

    /**
     * Update the specified resource in storage.
     * @param StoreLeaseFlowRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLeaseFlowRequest $request, $id)
    {
        $this -> checkAllowAccess('edit_lease_flow');
        $this -> leaseFlowRepo -> handleEdit($request, $id);
        $leaseFlow = $this -> leaseFlowRepo -> findOrFail($id);
        flash() -> overlay(trans('master.LeaseFlow has been updated!'), trans('master.Success!')) -> message();
        return redirect() -> route('leases.edit', $leaseFlow -> lease_id);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('delete_lease_flow');
        $leaseFlow = $this -> leaseFlowRepo -> findOrFail($id);
        $leaseId = $leaseFlow -> lease_id;
        $leaseFlow -> delete();
        return redirect() -> route('leases.edit', $leaseId);
    }

    /**
     * @param $lease
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generate($lease)
    {
        $this -> checkAllowAccess('create_lease_flow');
        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($lease);
        return view('Lease.lease-flows.generate', compact('lease'));
    }

    public function storeGeneratedPost(Request $request)
    {
        $this -> checkAllowAccess('create_lease_flow');
        $leaseId = $this -> leaseFlowRepo -> storeGeneratedPostData($request);
        return redirect() -> route('leases.edit', $leaseId);
    }

    /**
     * @param GenerateLeaseFlowRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generatePost(GenerateLeaseFlowRequest $request)
    {
        $this -> checkAllowAccess('edit_lease');
        list($paymentDates, $lease, $startDate, $fees) = $this -> leaseFlowRepo -> getGeneratedData($request);
        $leasePayment = request() -> get('lease_payment_amount');
        return view('Lease.lease-flows.generate_view', compact('paymentDates', 'lease', 'startDate',
            'leasePayment', 'fees'));
    }

    /**
     * @param $leaseId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll($leaseId)
    {
        $this -> checkAllowAccess('delete_lease_flow');
        LeaseFlow ::where('lease_id', $leaseId) -> withTrashed() -> where('locked', 0) -> forcedelete();
        LeaseExtension ::where('lease_id', $leaseId)-> withTrashed() -> forcedelete();

        $lease = Lease ::withoutGlobalScope(LeaseAccountableScope::class) -> findOrFail($leaseId);

        event(new ClearAll($lease));

        flash() -> overlay(trans('master.All lease flows and lease changes are deleted')) -> message();
        return redirect() -> route('leases.edit', $leaseId);
    }
}
