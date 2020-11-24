<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\FxRateDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StoreFxRateRequest;
use App\Zen\Setting\Features\Import\Upload\FxRateImport;
use App\Zen\Setting\Model\FxRate;
use App\Zen\Setting\Model\FxRatePair;
use App\Zen\Setting\Model\FxRateRepository as FxRateRepo;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Service\ImportService;
use App\Zen\Setting\Update\FxRate\FxRateUpdateFactory;
use App\Zen\System\Model\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FxRateController extends Controller
{
    /**
     * @var FxRateRepo
     */
    private $fxRateRepo;

    /**
     * FxRateController constructor.
     * @param FxRateRepo $fxRateRepo
     */
    public function __construct(FxRateRepo $fxRateRepo)
    {
        $this -> fxRateRepo = $fxRateRepo;
    }

    /**
     * Display a listing of the resource.
     * @param FxRateDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(FxRateDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        return $dataTable -> render('Setting.fxrates.index');

    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> checkAllowAccess('create_fxrate');
        list($currencies) = $this -> fxRateRepo -> getCreateViewData();
        return view('Setting.fxrates.create', compact('currencies'));
    }

    /**
     * @param StoreFxRateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFxRateRequest $request)
    {
        $this -> checkAllowAccess('create_fxrate');
        $this -> fxRateRepo -> handleCreate($request);
        flash() -> overlay(trans('master.FxRate Created'), trans('master.Success!'));
        return redirect() -> route('fxrates.index');
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this -> checkAllowAccess('delete_fxrate');
        $fxRate = $this -> fxRateRepo -> find($id);
        return view('Setting.fxrates.delete', compact('fxRate'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('edit_fxrate');
        list($fxRate, $users, $updatedUsers, $currencies) = $this -> fxRateRepo -> getEditViewData($id);
        return view('Setting.fxrates.edit', compact('fxRate', 'users', 'updatedUsers', 'currencies'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function copy($id)
    {
        $this -> checkAllowAccess('create_fxrate');
        list($fxRate, $users, $updatedUsers, $currencies) = $this -> fxRateRepo -> getEditViewData($id);
        return view('Setting.fxrates.copy', compact('fxRate', 'users', 'updatedUsers', 'currencies'));
    }

    /**
     * @param StoreFxRateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreFxRateRequest $request, $id)
    {
        $this -> checkAllowAccess('edit_fxrate');
        $this -> fxRateRepo -> handleEdit($request, $id);
        flash() -> overlay(trans('master.FxRate Updated'), trans('master.Success!'));
        return redirect() -> route('fxrates.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('delete_fxrate');
        FxRate ::destroy($id);
        flash() -> overlay('Fx rate deleted', 'Deleted!');
        return redirect() -> route('fxrates.index');
    }

    public function pair()
    {
        $this -> checkAllowAccess('create_fxrate');
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        $currencyPairs = FxRatePair ::all();
        return view('Setting.fxrates.pair', compact('currencies', 'currencyPairs'));
    }

    public function pairPost(Request $request)
    {
        $this -> checkAllowAccess('create_fxrate');
        $validation = $this -> validate($request, [
            'base_currency' => 'required',
            'converting_currency' => 'required',
            'referencing_currency' => 'required',
        ]);
        $result = $this -> fxRateRepo -> handlePairPost($request);
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        $currencyPairs = FxRatePair ::all();
        return view('Setting.fxrates.pair', compact('currencies', 'currencyPairs'));
    }

    public function pairDelete($id)
    {
        $this -> checkAllowAccess('delete_fxrate');
        $currencyPair = FxRatePair ::findOrFail($id);
        $currencyPair -> delete();
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        $currencyPairs = FxRatePair ::all();
        flash() -> message(trans('master.The given pair is deleted.')) -> overlay();
        return view('Setting.fxrates.pair', compact('currencies', 'currencyPairs'));
    }

    public static function updateRate()
    {
        $database = config('database.connections.tenant.database');
        $customer = Customer ::where('database', $database) -> first();
        (new FxRateUpdateFactory()) -> getRateClass($customer -> fx_rate_source) -> update($customer);
        flash() -> overlay(trans('master.Rate updated!'), trans('master.Success!'));
        return redirect() -> route('fxrates.index');
    }

    /*public function importPost()
    {
        set_time_limit(20000);

        $this -> checkAllowAccess('import_data');

        $this -> fxRateRepo -> handleImport();

        return back();
    }*/


    public function importPost(Request $request)
    {

        $this -> checkAllowAccess('import_fxrate');
        list($path, $importFile) = ImportService ::importService($request -> file('fxrate_excel'), 'Import/FxRate');
        Excel ::queueImport(new FxRateImport($importFile), $path, 'google_la_customer', \Maatwebsite\Excel\Excel::XLSX);
        flash() -> overlay(trans('master.Your excel will be imported!',['file' => 'fx-rate']), trans('master.Success!')) -> message();
        return back();
    }


}
