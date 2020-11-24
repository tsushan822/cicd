<?php

namespace App\Http\Controllers\Setting;

use App\DataTables\Setting\CountryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StoreCountryRequest;
use App\Zen\Setting\Model\Country;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\CountryRepository as CountryRepo;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     * @var CountryRepo
     */
    private $countryRepo;

    /**
     * CountryController constructor.
     * @param CountryRepo $countryRepo
     */
    public function __construct(CountryRepo $countryRepo)
    {
        $this -> countryRepo = $countryRepo;
    }

    /**
     * Display a listing of the resource.
     * @param CountryDataTable $dataTable
     * @return \Illuminate\View\View
     */
    public function index(CountryDataTable $dataTable)
    {
        $this -> checkAllowAccess('can_view');
        return $dataTable -> render('Setting.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this -> checkAllowAccess('create_country');
        $currencies = Currency ::all() -> pluck('iso_4217_code', 'id');
        return view('Setting.countries.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCountryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCountryRequest $request)
    {
        $this -> checkAllowAccess('create_country');
        $requestData = $request -> all() + ['user_id' => Auth ::id()];
        Country ::create($requestData);
        flash() -> overlay('Country added!', 'Success') -> message();
        return redirect() -> route('countries.index');
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $country = Country ::findOrFail($id);
        return view('Setting.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this -> checkAllowAccess('edit_country');
        $country = Country ::findOrFail($id);
        $currencies = Currency ::all() -> pluck('iso_4217_code', 'id');
        return view('Setting.countries.edit', compact('country', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     * @param StoreCountryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreCountryRequest $request, $id)
    {

        $requestData = $request -> all() + ['updated_user_id' => Auth ::id()];
        $country = Country ::findOrFail($id);
        $country -> update($requestData);
        flash() -> overlay('Country updated!', 'Success') -> message();
        return redirect() -> route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Country ::destroy($id);
        flash() -> overlay('Country deleted!', 'Success') -> message();
        return redirect() -> route('countries.index');
    }
}
