<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 26/10/2017
 * Time: 9.21
 */

namespace App\Zen\Setting\Model;

use App\Repository\Eloquent\Repository;
use App\Zen\Setting\Features\Import\Upload\AccountUpload;
use Illuminate\Support\Facades\Auth;

class AccountRepository extends Repository
{
    public function model()
    {
        return Account::class;
    }

    public function getIndexViewData()
    {
        $accounts = Account :: refactorEntity() -> get();
        return array($accounts);
    }

    public function getEditViewData($id)
    {
        list($counterparties, $currencies, $countries) = $this -> getCreateViewData();
        $account = $this -> find($id);
        return array($counterparties, $currencies, $countries, $account);
    }

    public function getCreateViewData()
    {
        $counterparties = Counterparty ::internal() -> allowedEntity() -> get() -> pluck('short_name', 'id');
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        $countries = Country ::orderBy('name') -> get() -> pluck('name', 'id');
        return array($counterparties, $currencies, $countries);
    }

    public function handleEdit($request, $id)
    {
        $account = $this -> findOrFail($id);
        $this -> checkIfAllowedForThisEntity($account -> counterparty_id);
        $returnData = $account -> update($request -> all() + ['user_id' => Auth ::id()]);
        flash() -> overlay(trans('master.Account updated'), trans('master.Success!'));

    }

    public function handleCreate($request)
    {
        $returnData = $this -> create($request -> all());
        flash() -> overlay(trans('master.New Account created'), trans('master.Success!'));

    }

    /**
     *
     */
    public function handleImport()
    {
        $file = request() -> file('account_excel');

        list($extension, $numberOfUploads) = (new AccountUpload()) -> uploadToDatabase($file);

        flash() -> overlay($numberOfUploads . ' account(s) are imported from ' . $extension . ' file') -> message();
    }
}