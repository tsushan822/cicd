<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\CostCenterDataTable;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Setting\StoreCostCenterRequest;
use App\Zen\Setting\Features\Import\Upload\CostCenterImport;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\CostCenterRepository as CostCenterRepo;
use App\Zen\Setting\Service\ImportService;
use Maatwebsite\Excel\Facades\Excel;

class CostCenterController extends Controller
{
    /**
     * @var CostCenterRepo
     */
    private $costCenterRepo;

    /**
     * CostCenterController constructor.
     * @param CostCenterRepo $costCenterRepo
     */
    public function __construct(CostCenterRepo $costCenterRepo)
    {
        $this -> costCenterRepo = $costCenterRepo;
    }

    /**
     * Display a listing of the resource.
     * @param CostCenterDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(CostCenterDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        return $dataTable -> render('Setting.costcenters.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function copy($id)
    {
        $this -> checkAllowAccess('create_costcenter');
        $costCenter = $this -> costCenterRepo -> find($id);
        list($portfolios) = $this -> costCenterRepo -> getCreateViewData();
        return view('Setting.costcenters.copy', compact('costCenter', 'portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> checkAllowAccess('create_costcenter');
        list($portfolios) = $this -> costCenterRepo -> getCreateViewData();
        return view('Setting.costcenters.create', compact('portfolios'));
    }

    /**
     * @param StoreCostCenterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCostCenterRequest $request)
    {
        $this -> checkAllowAccess('create_costcenter');
        $this -> costCenterRepo -> handleCreate($request);
        return redirect() -> route('costcenters.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('edit_costcenter');
        $costCenter = $this -> costCenterRepo -> find($id);
        list($portfolios) = $this -> costCenterRepo -> getCreateViewData();
        return view('Setting.costcenters.edit', compact('costCenter', 'portfolios'));
    }

    public function update(StoreCostCenterRequest $request, $id)
    {
        $this -> checkAllowAccess('edit_costcenter');
        $resultData = $this -> costCenterRepo -> handleEdit($request, $id);
        flash() -> overlay(trans('master.Cost Center Updated'), trans('master.Updated!'));

        return redirect() -> route('costcenters.edit', $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('delete_costcenter');
        if($this -> costCenterRepo -> checkDeletable($id))
            throw new CustomException(trans('master.This costcenter can\'t be deleted as it has leases associated with it'));

        $resultData = CostCenter ::destroy($id);
        flash() -> overlay(trans('master.Cost Center Deleted'), trans('master.Deleted!'));
        return redirect(route('costcenters.index'));
    }

    public function show($id)
    {
        $costCenter = $this -> costCenterRepo -> find($id);
        return view('Setting.costcenters.delete', compact('costCenter'));
    }

    /*public function importPost()
    {
        set_time_limit(20000);

        $this -> checkAllowAccess('import_data');

        $this -> costCenterRepo -> handleImport();

        return back();
    }*/

    public function importPost(Request $request)
    {

        $this -> checkAllowAccess('import_costcenter');
        list($path, $importFile) = ImportService ::importService($request -> file('costcenter_excel'), 'Import/Costcenter');
        Excel ::queueImport(new CostCenterImport($importFile), $path, 'google_la_customer', \Maatwebsite\Excel\Excel::XLSX);
        flash() -> overlay(trans('master.Your excel will be imported!', ['file' => 'cost center']), trans('master.Success!')) -> message();
        return back();
    }
}
