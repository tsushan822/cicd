<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 25/10/2017
 * Time: 16.28
 */

namespace App\Zen\Setting\Model;

use App\Repository\Eloquent\Repository;
use Illuminate\Support\Facades\Auth;

class CurrencyRepository extends Repository
{
    public function model()
    {
        return Currency::class;
    }

    public function handleCreate($request)
    {
        $attrCurrency = [
            'iso_4217_code' => $request -> iso_4217_code,
            'iso_3166_code' => $request -> iso_3166_code,
            'iso_number' => $request -> iso_number,
            'currency_name' => $request -> currency_name,
            'active_status' => $request -> active_status,
            'user_id' => Auth ::id(),
        ];
        $result = $this -> create($attrCurrency);
    }

    public function handleEdit($request, $id)
    {
        $currency = $this -> find($id);//Currency::find($id);
        $currency -> active_status = $request -> active_status;
        $currency -> updated_user_id = Auth ::id();
        $currency -> save();
    }
}