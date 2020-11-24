<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\CounterpartyDataTable;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Zen\System\Service\ModuleAvailabilityService;
use Illuminate\Http\Request;
use App\Http\Requests\Setting\StoreCounterpartyRequest;
use App\Zen\Setting\Features\Import\Upload\CounterpartyImport;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\CounterpartyRepository as CounterpartyRepo;
use App\Zen\Setting\Service\ImportService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CounterpartyController extends Controller
{
    /**
     * @var CounterpartyRepo
     */
    private $counterpartyRepo;

    /**
     * CounterpartyController constructor.
     * @param CounterpartyRepo $counterpartyRepo
     */
    public function __construct(CounterpartyRepo $counterpartyRepo)
    {
        $this -> counterpartyRepo = $counterpartyRepo;
        $this -> middleware('moduleNumber:Company') -> only(['create', 'store','copy']);
    }

    /**
     * Display a listing of the resource.
     * @param CounterpartyDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(CounterpartyDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        $view['add_new'] = $this -> checkAllowAccessWithoutException('create_counterparty') && ModuleAvailabilityService ::availabilityCount('Company');
        $view['import'] = $this -> checkAllowAccessWithoutException('create_counterparty') && ModuleAvailabilityService ::availabilityCount('Company');
        return $dataTable -> render('Setting.counterparties.index', compact('view'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> checkAllowAccess('create_counterparty');
        list($currencies, $countries) = $this -> counterpartyRepo -> getCreateViewData();
        return view('Setting.counterparties.create', compact('currencies', 'countries'));
    }

    public function getSetup()
    {
        //$this -> checkAllowAccess('create_counterparty');
        list($currencies, $countries) = $this -> counterpartyRepo -> getCreateViewData();
        return compact('currencies', 'countries');
    }

    public function postSetup(StoreCounterpartyRequest $request)
    {
        //$this -> checkAllowAccess('create_counterparty');
        $counterparty = $this -> counterpartyRepo -> handleCreate($request);
        return 1;
    }

    /**
     * @param StoreCounterpartyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCounterpartyRequest $request)
    {

        $this -> checkAllowAccess('create_counterparty');
        $counterparty = $this -> counterpartyRepo -> handleCreate($request);
        flash() -> overlay(trans('master.Company Saved!'), trans('master.Success!'));
        return redirect() -> route('counterparties.index');
    }

    public function copy(Counterparty $counterparty)
    {
        $this -> checkAllowAccess('create_counterparty');
        $view['copy'] = $this -> checkAllowAccessWithoutException('create_counterparty') && ModuleAvailabilityService ::availabilityCount('Company');
        flash() -> overlay(trans('master.You are creating a copy. Please update all fields.')) -> message();
        list($counterparty, $currencies, $countries) =
            $this -> counterpartyRepo -> getEditViewData($counterparty -> id);
        return view('Setting.counterparties.copy', compact('counterparty', 'currencies', 'countries','view'));
    }

    public function edit(Counterparty $counterparty)
    {
        $this -> checkAllowAccess('edit_counterparty');
        list($counterparty, $currencies, $countries) =
            $this -> counterpartyRepo -> getEditViewData($counterparty -> id);
        return view('Setting.counterparties.edit', compact('counterparty', 'currencies', 'countries'));
    }

    public function update(StoreCounterpartyRequest $request, Counterparty $counterparty)
    {
        $this -> checkAllowAccess('edit_counterparty');
        $this -> counterpartyRepo -> handleEdit($request, $counterparty -> id);
        flash() -> overlay(trans('master.Company updated'), trans('master.Success!'));
        return redirect() -> route('counterparties.edit', $counterparty -> id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultData = Counterparty ::destroy($id);
        flash() -> overlay(trans('master.Company Deleted'), trans('master.Deleted!'));
        return redirect(route('counterparties.index'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws CustomException
     */
    public function show($id)
    {
        $this -> checkAllowAccess('delete_counterparty');
        $counterparty = $this -> counterpartyRepo -> find($id);
        if($this -> counterpartyRepo -> checkDeletable($id))
            throw new CustomException(trans('master.This company can\'t be deleted as it has data associated with it'));

        return view('Setting.counterparties.delete', compact('counterparty'));
    }

    /*public function handleImport()
    {
        $this -> checkAllowAccess('import_data');
        $this -> counterpartyRepo -> handleImport();
        return back();
    }*/

    public function handleImport(Request $request)
    {
        $this -> checkAllowAccess('import_counterparty');
        list($path, $importFile) = ImportService ::importService($request -> file('company_excel'), 'Import/Counterparty');
        Excel ::queueImport(new CounterpartyImport($importFile), $path, 'google_la_customer', \Maatwebsite\Excel\Excel::XLSX);
        flash() -> overlay(trans('master.Your excel will be imported!',['file' => 'company']), trans('master.Success!')) -> message();
        return back();
    }

    public function createParentCompany()
    {
        $parentCompany = DB ::select('SELECT * FROM counterparties WHERE is_parent_company = ?', [1]);
        if($parentCompany)
            throw new CustomException(trans('master.Parent company already present'));
        list($currencies, $countries) = $this -> counterpartyRepo -> getCreateViewData();
        return view('Setting.counterparties.create', compact('currencies', 'countries'));
    }
}
