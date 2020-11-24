<?php

namespace App\Http\Controllers\Lease;

use App\DataTables\Lease\LeaseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lease\StoreLeaseRequest;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseRepository as LeaseRepo;
use App\Zen\Setting\Features\Import\Upload\LeaseImport;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Service\ImportService;
use App\Zen\User\Dashboard\Lease\LeaseFlowDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Facades\Excel;

class LeaseController extends Controller
{
    /**
     * @var LeaseRepo
     */
    private $leaseRepo;

    /**
     * LeaseController constructor.
     * @param LeaseRepo $leaseRepo
     */
    public function __construct(LeaseRepo $leaseRepo)
    {
        $this -> leaseRepo = $leaseRepo;
        $this -> middleware('module:Lease');
        $this -> middleware('moduleNumber:Lease') -> only(['create', 'store']);
    }

    public function index(LeaseDataTable $dataTable)
    {
        $lease = Lease ::refactorEntity() -> where('source', 'seeder') -> first();
        $numberOfLeases = $dataTable -> getNumber();
        $this -> checkAllowAccess('view_lease');
        return $dataTable -> render('Lease.leases.index', compact('numberOfLeases', 'lease'));
    }

    /**
     * Display a listing of the resource.
     * @param LeaseDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function archive(LeaseDataTable $dataTable)
    {
        $lease = Lease ::refactorEntity() -> where('source', 'seeder') -> archive() -> first();
        $this -> checkAllowAccess('view_lease');
        $numberOfLeases = $dataTable -> setIsArchived(true) -> getNumber();
        return $dataTable -> setIsArchived(true) -> render('Lease.leases.index', compact('numberOfLeases', 'lease'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this -> checkAllowAccess('create_lease');
        list($entities, $counterparties, $costCenters, $currencies, $accounts, $portfolios, $leaseTypes,
            $paymentDays, $buttonShow, $costCenterSplits) = $this -> leaseRepo -> getCreateViewData();
        return view('Lease.leases.create', compact('entities', 'counterparties', 'costCenters',
            'currencies', 'accounts', 'portfolios', 'leaseTypes', 'paymentDays', 'buttonShow', 'costCenterSplits'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreLeaseRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreLeaseRequest $request)
    {
        $this -> checkAllowAccess('create_lease');
        $lease = $this -> leaseRepo -> handleCreate($request);
        return redirect() -> route('lease-flows.generate', $lease -> id);

    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this -> checkAllowAccess('delete_lease');
        $lease = $this -> leaseRepo -> findWithoutScope($id);
        return view('Lease.leases.show', compact('lease'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\View\View
     * @throws \App\Exceptions\CustomException
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('view_lease');
        $lease = $this -> leaseRepo -> findWithoutScope($id);
        list($entities, $counterparties, $costCenters, $currencies, $accounts, $portfolios, $leaseTypes, $leaseFlows,
            $leaseExtensions, $disabled, $files, $paymentDays, $buttonShow, $costCenterSplits) = $this -> leaseRepo -> getEditViewData($lease);
        return view('Lease.leases.edit', compact('entities', 'counterparties', 'costCenters',
            'currencies', 'accounts', 'portfolios', 'leaseTypes', 'lease', 'leaseFlows', 'leaseExtensions',
            'disabled', 'files', 'paymentDays', 'buttonShow', 'costCenterSplits'));
    }

    /**
     * Update the specified resource in storage.
     * @param StoreLeaseRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreLeaseRequest $request, $id)
    {
        $this -> checkAllowAccess('edit_lease');
        $lease = $this -> leaseRepo -> handleEdit($request, $id);
        return redirect() -> route('leases.edit', $lease -> id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('delete_lease');
        Lease ::destroy($id);
        return redirect('leases') -> with('flash_message', 'Lease deleted!');
    }

    /**
     * @param $leaseId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copy($leaseId)
    {
        $this -> checkAllowAccess('create_lease');
        $lease = $this -> leaseRepo -> findWithoutScope($leaseId);
        flash() -> overlay(Lang ::get('master.You are creating a copy. Please update all fields.')) -> message();
        list($entities, $counterparties, $costCenters, $currencies, $accounts, $portfolios, $leaseTypes,
            $leaseFlows, $leaseExtensions, $disabled, $files, $paymentDays, $buttonShow, $costCenterSplits) = $this -> leaseRepo -> getEditViewData($lease);
        return view('Lease.leases.copy', compact('entities', 'counterparties', 'costCenters', 'currencies',
            'accounts', 'portfolios', 'leaseTypes', 'lease', 'leaseFlows', 'leaseExtensions', 'files', 'paymentDays', 'buttonShow', 'costCenterSplits'));
    }

    /**
     *Get counterparty
     */
    public function leaseDetail()
    {
        $entityId = request() -> get('entityId');
        $query = Counterparty ::findOrFail($entityId);
        return $query;
    }

    public function liabilityPerType()
    {
        return (new LeaseFlowDashboard()) -> assetLiabilityPerType();
    }

    public function liabilityPerLessor()
    {
        return (new LeaseFlowDashboard()) -> liabilityPerLessor();
    }

    public function maturityGraph()
    {
        return (new LeaseFlowDashboard()) -> maturityGraph();
    }

    public function deleteExtension($leaseExtensionId)
    {
        $this -> checkAllowAccess('delete_lease');
        $leaseExtension = LeaseExtension ::findOrFail($leaseExtensionId);
        $leaseId = $leaseExtension -> lease_id;
        $this -> leaseRepo -> deleteExtension($leaseExtensionId);
        return redirect() -> route('leases.edit', $leaseId) -> with('flash_message', trans('master.Lease Extension deleted!'));
    }

    /*public function importPost()
    {
        set_time_limit(20000);

        $this -> checkAllowAccess('import_lease');

        $this -> leaseRepo -> handleImport();

        return back();
    }*/


    public function importPost(Request $request)
    {
        $this -> checkAllowAccess('import_lease');
        list($path, $importFile) = ImportService ::importService($request -> file('lease_excel'), 'Import/Lease');
        Excel ::queueImport(new LeaseImport($importFile), $path, 'google_la_customer', \Maatwebsite\Excel\Excel::XLSX);
        flash() -> overlay(trans('master.Your excel will be imported!',['file' => 'lease']), trans('master.Success!')) -> message();
        return back();
    }

    public function deleteDemo()
    {
        $leaseIds = Lease ::where('source', 'seeder') -> pluck('id') -> toArray();
        foreach($leaseIds as $leaseId) {
            Lease ::destroy($leaseId);
        }
        return redirect() -> back() -> with('flash_message', 'Initial demo leases has been removed');
    }
}
