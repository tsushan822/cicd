<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\CurrencyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StoreCurrencyRequest;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\CurrencyRepository as CurrencyRepo;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepo
     */
    private $currencyRepo;

    public function __construct(CurrencyRepo $currencyRepo)
    {
        $this -> currencyRepo = $currencyRepo;
    }

    /**
     * Display a listing of the resource.
     * @param CurrencyDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        return $dataTable -> render('Setting.currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> checkAllowAccess('is_superadmin');
        return view('Setting.currencies.create');
    }

    /**
     * @param StoreCurrencyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCurrencyRequest $request)
    {
        $this -> checkAllowAccess('is_superadmin');
        $this -> currencyRepo -> handleCreate($request);
        flash() -> overlay('Currency Created', 'Success !!');
        return redirect() -> route('currencies.index');
    }


    /**
     * @param Currency $currency
     */
    public function show(Currency $currency)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        $this -> checkAllowAccess('is_superadmin');
        return view('Setting.currencies.edit', compact('currency'));
    }

    /**
     * @param StoreCurrencyRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreCurrencyRequest $request, $id)
    {
        $this -> checkAllowAccess('is_superadmin');
        $this -> currencyRepo -> handleEdit($request, $id);
        flash() -> overlay('Currency Updated', 'Updated !!');
        return redirect() -> route('currencies.edit', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this -> checkAllowAccess('is_superadmin');
        $this -> currencyRepo -> delete($id);
        return redirect() -> route('currencies.index');
    }
}
