<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\AccountDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Setting\StoreAccountRequest;
use App\Zen\Setting\Features\Import\Upload\AccountImport;
use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Model\AccountRepository as AccountRepo;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Service\ImportService;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    /**
     * @var AccountRepo
     */
    private $accountRepo;

    /**
     * AccountController constructor.
     * @param AccountRepo $accountRepo
     */
    public function __construct(AccountRepo $accountRepo)
    {
        $this -> accountRepo = $accountRepo;
    }

    /**
     * Display a listing of the resource.
     * @param AccountDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AccountDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        return $dataTable -> render('Setting.accounts.index');
    }

    /**
     * @param $accountCopyId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function copy($accountCopyId)
    {
        $this -> checkAllowAccess('edit_account');
        list($counterparties, $currencies, $countries, $account) =
            $this -> accountRepo -> getEditViewData($accountCopyId);
        return view('Setting.accounts.copy', compact('account', 'counterparties', 'currencies', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> checkAllowAccess('create_account');
        list($counterparties, $currencies, $countries) = $this -> accountRepo
            -> getCreateViewData();
        return view('Setting.accounts.create', compact('currencies', 'counterparties', 'countries'));
    }

    public function getSetup()
    {
        $this -> checkAllowAccess('create_account');
        list($counterparties, $currencies, $countries) = $this -> accountRepo
            -> getCreateViewData();
        return compact('currencies', 'counterparties', 'countries');
    }

    public function postSetup(StoreAccountRequest $request)
    {
        $this -> checkAllowAccess('create_account');
        $this -> accountRepo -> handleCreate($request);
        return 1;
    }

    /**
     * Show the form for creating a new resource.
     * @param $companyId
     * @return \Illuminate\Http\Response
     */
    public function createWithCompany($companyId)
    {
        $this -> checkAllowAccess('create_account');
        list($counterparties, $currencies, $countries) = $this -> accountRepo
            -> getCreateViewData();
        $company = Counterparty ::findOrFail($companyId);
        $counterparties[$company -> id] = $company -> short_name;
        $company = $company -> id;
        return view('Setting.accounts.create', compact('currencies', 'counterparties', 'countries', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAccountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $this -> checkAllowAccess('create_account');
        $this -> accountRepo -> handleCreate($request);
        return redirect() -> route('accounts.index');
    }

    public function show(Account $account)
    {
        $this -> checkAllowAccess('edit_account');
        return view('Setting.accounts.delete', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('edit_account');
        list($counterparties, $currencies, $countries, $account) =
            $this -> accountRepo -> getEditViewData($id);
        return view('Setting.accounts.edit', compact('account', 'counterparties', 'currencies', 'countries'));

    }

    /**
     * Update the specified resource in storage.
     * @param StoreAccountRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAccountRequest $request, $id)
    {
        $this -> checkAllowAccess('edit_account');
        $this -> accountRepo -> handleEdit($request, $id);
        return redirect() -> route('accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account -> delete();
        flash() -> overlay(trans('master.Account deleted'), trans('master.Success!'));
        return redirect() -> route('accounts.index');
    }

    /*public function handleImport()
    {
        set_time_limit(20000);
        $this -> checkAllowAccess('import_data');
        $this -> accountRepo -> handleImport();
        return back();
    }*/

    public function handleImport(Request $request)
    {
        $this -> checkAllowAccess('import_account');
        list($path, $importFile) = ImportService ::importService($request -> file('account_excel'), 'Import/Account');
        Excel ::queueImport(new AccountImport($importFile), $path, 'google_la_customer', \Maatwebsite\Excel\Excel::XLSX);
        return back();
    }
}
