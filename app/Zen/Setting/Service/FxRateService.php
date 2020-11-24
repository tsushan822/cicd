<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 06/08/2018
 * Time: 14.19
 */

namespace App\Zen\Setting\Service;

use App\Zen\Setting\Model\FxRate;
use Illuminate\Support\Facades\Auth;

class FxRateService
{
    public static function createOrUpdateRate($baseCurrencyId, $crossCurrencyId, $rate, $accountingDate)
    {
        $checkIfExist = self ::checkIfRateExist($baseCurrencyId, $crossCurrencyId, $accountingDate);
        if($checkIfExist)
            return false;
        $userId = Auth ::check() ? Auth ::id() : 1;
        $attr = [
            'ccy_base_id' => $baseCurrencyId,
            'ccy_cross_id' => $crossCurrencyId,
            'rate_bid' => $rate,
            'user_id' => $userId,
            'direct_quote' => 2,
            'date' => $accountingDate,
            'updated_user_id' => $userId,
        ];
        return FxRate ::create($attr);
    }

    public static function checkIfRateExist($baseCurrencyId, $crossCurrencyId, $accountingDate)
    {
        $result = FxRate ::where(['ccy_base_id' => $baseCurrencyId, 'ccy_cross_id' => $crossCurrencyId, 'date' => $accountingDate]) -> first();
        if($result instanceof FxRate)
            return true;

        return false;
    }
}