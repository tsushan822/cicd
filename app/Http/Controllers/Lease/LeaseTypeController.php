<?php

namespace App\Http\Controllers\Lease;

use App\DataTables\Lease\LeaseTypeDataTable;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Zen\Setting\Model\BusinessDayConvention;
use Illuminate\Http\Request;
use App\Zen\Lease\Model\LeaseTypeRepository as LeaseTypeRepo;

class LeaseTypeController extends Controller
{
    /**
     * @var LeaseTypeRepo
     */
    private $leaseTypeRepo;

    /**
     * LeaseTypeController constructor.
     * @param LeaseTypeRepo $leaseTypeRepo
     */
    public function __construct(LeaseTypeRepo $leaseTypeRepo)
    {

        $this -> leaseTypeRepo = $leaseTypeRepo;
        $this -> middleware('module:Lease');
    }

    public function index(LeaseTypeDataTable $dataTable)
    {
        $this -> checkAllowAccess('view_lease_type');
        return $dataTable -> render('Lease.lease-type.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this -> checkAllowAccess('create_lease_type');
        $leaseItemIcons = $this -> leaseTypeRepo -> itemIcon();
        $businessDayConventions = BusinessDayConvention ::get() -> pluck('convention', 'id') -> toArray();
        return view('Lease.lease-type.create', compact('leaseItemIcons', 'businessDayConventions'));
    }

    public function setupGet()
    {
        //$this -> checkAllowAccess('create_lease_type');
        $leaseItemIcons = $this -> leaseTypeRepo -> itemIcon();
        $businessDayConventions = BusinessDayConvention ::get() -> pluck('convention', 'id') -> toArray();
        return  compact('leaseItemIcons', 'businessDayConventions');
    }

    public function setupPost(Request $request)
    {
        //$this -> checkAllowAccess('create_lease_type');
        $validatedData = $request -> validate([
            'type' => ['required', 'unique:tenant.lease_types,type'],
            'lease_valuation_rate' => ['nullable', 'min:0', 'max:100', 'numeric'],
        ]);
        $leaseType = $this -> leaseTypeRepo -> handleCreate($request);
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this -> checkAllowAccess('create_lease_type');
        $validatedData = $request -> validate([
            'type' => ['required', 'unique:tenant.lease_types,type'],
            'lease_valuation_rate' => ['nullable', 'min:0', 'max:100', 'numeric'],
        ]);
        $leaseType = $this -> leaseTypeRepo -> handleCreate($request);
        return redirect() -> route('lease-types.edit', $leaseType -> id);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $this -> checkAllowAccess('view_lease_type');
        $leaseType = $this -> leaseTypeRepo -> findOrFail($id);
        return view('Lease.lease-type.show', compact('leaseType'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('edit_lease_type');
        $leasetype = $this -> leaseTypeRepo -> findOrFail($id);
        $leaseItemIcons = $this -> leaseTypeRepo -> itemIcon();
        $businessDayConventions = BusinessDayConvention ::get() -> pluck('convention', 'id') -> toArray();
        return view('Lease.lease-type.edit', compact('leasetype', 'leaseItemIcons', 'businessDayConventions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function copy($id)
    {
        $this -> checkAllowAccess('edit_lease_type');
        $leaseType = $this -> leaseTypeRepo -> findOrFail($id);
        $leaseItemIcons = $this -> leaseTypeRepo -> itemIcon();
        $businessDayConventions = BusinessDayConvention ::get() -> pluck('convention', 'id') -> toArray();
        return view('Lease.lease-type.copy', compact('leaseType', 'leaseItemIcons', 'businessDayConventions'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this -> checkAllowAccess('edit_lease_type');
        $validatedData = $request -> validate([
            'type' => ['required', 'unique:tenant.lease_types,type,' . $id],
            'lease_valuation_rate' => ['nullable', 'min:0', 'max:100', 'numeric'],
        ]);
        $this -> leaseTypeRepo -> handleEdit($request, $id);
        return redirect() -> route('lease-types.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('delete_lease_type');
        if($this -> leaseTypeRepo -> checkDeletable($id))
            throw new CustomException(trans('master.This lease-type can\'t be deleted as it has leases associated with it'));

        $this -> leaseTypeRepo -> findOrFail($id) -> delete();
        flash() -> message(trans('master.Lease type deleted!'), trans('master.Deleted!')) -> overlay();
        return redirect() -> route('lease-types.index');
    }
}
