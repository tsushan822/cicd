<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\StoreCurrencySetupRequest;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\System\Model\Customer;
use Hyn\Tenancy\Facades\TenancyFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Spark\TeamSubscription;

class SetupController extends Controller
{

    public function __construct()
    {
        $this -> middleware(['token']) -> only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Pages.setup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function models()
    {
        $modelsArray = [];

        array_push($modelsArray, ['Currency' => +(Currency ::where('active_status', '=', '1') -> count() > 0)]);
        array_push($modelsArray, ['Counter party' => +(Counterparty ::where('is_parent_company', '!=', '1') -> count() > 0)]);
        array_push($modelsArray, ['Lease type' => +(LeaseType ::count() > 0)]);

        return $modelsArray;

    }


    public function getCurrencies()
    {
        return Currency ::all('id', 'iso_4217_code', 'iso_3166_code', 'currency_name');
    }

    public function postCurrencies(StoreCurrencySetupRequest $request)
    {
        $allCurrencies = $request -> currency_ids;
        foreach($allCurrencies as $currency) {
            $currencyObj = Currency ::find($currency);
            if($currencyObj instanceof Currency) {
                $currencyObj -> active_status = 1;
                $currencyObj -> save();
                $arrAccount = [
                    'counterparty_id' => 1,
                    'account_name' => $currencyObj -> iso_4217_code,
                    'currency_id' => $currency,
                    'country_id' => $currencyObj -> country_id,
                ];
                Account ::create($arrAccount);
            }
        }
    }

    public function notificationForRedirectToLeaseCreatePage()
    {
        flash() -> overlay(trans('master.Create a new lease'), trans('master.Final step!')) -> message();
    }

    public function trialNotice()
    {
        return auth() -> user() -> teams[0] -> trial_ends_at -> diffForHumans();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
