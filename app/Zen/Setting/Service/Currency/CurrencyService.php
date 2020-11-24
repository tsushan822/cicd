<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 20/04/2018
 * Time: 10.57
 */

namespace App\Zen\Setting\Service\Currency;

use App\Zen\Setting\Model\Counterparty;

class CurrencyService
{
    public static function getCompanyBaseCurrency($entityId = null)
    {
        if($entityId) {
            $counterparty = Counterparty ::find($entityId);
        } else {
            $counterparty = Counterparty ::parent();
        }
        return $counterparty -> currency;
    }
}