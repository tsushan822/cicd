<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 04/10/2018
 * Time: 14.42
 */

namespace App\Zen\Setting\Update\FxRate;

use Exception;

class FxRateUpdateFactory
{
    /**
     * @param $rateSource
     * @return UpdateFxRate
     * @throws Exception
     */
    public static function getRateClass($rateSource): UpdateFxRate
    {
        $rateSource = strtolower($rateSource);

        switch($rateSource){
            case 'ecb-rate':
                return new ECBRateUpdate();
            case 'riksbank':
                return new RiksBankRateUpdate();
            default:
                throw new Exception('The source ' . $rateSource . ' is not found.');
        }
    }
}