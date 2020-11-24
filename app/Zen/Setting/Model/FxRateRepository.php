<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 31/10/2017
 * Time: 14.43
 */

namespace App\Zen\Setting\Model;

use App\Repository\Eloquent\Repository;
use App\Zen\Setting\Features\Import\Upload\FxRateUpload;
use App\Zen\User\Model\User;
use Illuminate\Support\Facades\Auth;

class FxRateRepository extends Repository
{
    public function model()
    {
        return FxRate::class;
    }

    public function getIndexViewData()
    {
        return $this -> all();
    }

    public function getEditViewData($id)
    {
        $fxRate = $this -> find($id);
        $users = User ::where('id', '=', $fxRate -> user_id) -> get();
        $updatedUsers = User ::where('id', '=', $fxRate -> updated_user_id) -> get();
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        return array($fxRate, $users, $updatedUsers, $currencies);
    }

    public function getCreateViewData()
    {
        $currencies = Currency ::active() -> pluck('iso_4217_code', 'id');
        return array($currencies);
    }

    public function handleCreate($request)
    {
        $attrFxRate = $request -> all();
        $attrFxRate['user_id'] = Auth ::id();
        $returnData = $this -> create($attrFxRate);

    }

    public function handleEdit($request, $id)
    {
        $attrFxRate = $request -> all();
        $attrFxRate['updated_user_id'] = Auth ::id();
        $returnData = $this -> find($id) -> update($attrFxRate);
    }

    public function handlePairPost($request)
    {
        $result = FxRatePair ::updateOrCreate(
            ['base_currency' => $request -> base_currency, 'converting_currency' => $request -> converting_currency,
                'referencing_currency' => $request -> referencing_currency]);
        return $result;
    }

    public function handleImport()
    {
        $file = request() -> file('fxrate_excel');

        list($extension, $numberOfUploads) = (new FxRateUpload()) -> uploadToDatabase($file);

        flash() -> overlay($numberOfUploads . ' fxrate(s) are imported from ' . $extension . ' file') -> message();
    }

}