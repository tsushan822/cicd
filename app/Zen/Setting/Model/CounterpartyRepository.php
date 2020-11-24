<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/10/2017
 * Time: 16.59
 */

namespace App\Zen\Setting\Model;

use App\Repository\Eloquent\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CounterpartyRepository extends Repository
{

    public function model()
    {
        return Counterparty::class;
    }

    public function getIndexData()
    {
        $counterparties = Counterparty ::all();
        return $counterparties;
    }

    public function getEditViewData($id)
    {
        list($currencies, $countries) = $this -> getCreateViewData();
        $counterparty = $this -> findOrFail($id);
        return array($counterparty, $currencies, $countries);
    }

    public function getCreateViewData()
    {
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        $countries = Country ::orderBy('name') -> get() -> pluck('name', 'id');
        return array($currencies, $countries);
    }

    public function handleCreate($request)
    {
        $request -> request -> add(['user_id' => Auth ::id(), 'updated_user_id' => Auth ::id()]);

        $this -> addParentCompanyVariable($request);

        $counterparty = $this -> create($request -> all());

        if($counterparty -> is_entity)
            auth() -> user() -> counterparties() -> save($counterparty);

        return $counterparty;
    }

    public function handleEdit($request, $id)
    {
        return $this -> find($id) -> update($request -> all() + ['updated_user_id' => Auth ::id()]);
    }

    public function checkDeletable($counterpartyId)
    {
        $counterparty = Counterparty ::with('accounts', 'lessors', 'leases') -> findOrFail($counterpartyId);
        return count($counterparty -> accounts)
            || count($counterparty -> leases) || count($counterparty -> lessors);
    }

    /**
     * @param $request
     */
    private function addParentCompanyVariable($request): void
    {
        $lastUrl = Request ::server('HTTP_REFERER');
        if(strpos($lastUrl, 'parent') !== false) {
            $request -> request -> add(['is_parent_company' => 1]);
        }
    }

    /* public function handleImport()
     {
         $file = request() -> file('company_excel');

         list($extension, $numberOfUploads) = (new CounterpartyUpload()) -> uploadToDatabase($file);

         flash() -> overlay($numberOfUploads . ' compan(y)ies are imported from ' . $extension . ' file') -> message();

     }*/

}