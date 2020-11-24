<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/02/2018
 * Time: 13.32
 */

namespace App\Zen\Setting\Update\FxRate;

use App\Zen\System\Model\MainFx as FxRate;
use Carbon\Carbon;

class ECBRateUpdate extends UpdateFxRate
{

    public function getSource()
    {
        //get ecb rates
        //the file is updated daily between 2.15 p.m. and 3.00 p.m. CET
        $XMLContent = file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
        return $XMLContent;
    }

    public function getDate()
    {
        /*//parse date from XMLContent
        foreach($this -> output as $line) {
            if(preg_match("/time='([[:graph:]]+)'/", $line, $time)) {
                $date = $time[1];
                return $date;
            }
        }*/
        return Carbon ::today() -> toDateString();
    }

    function getData()
    {
        foreach($this -> output as $line) {
            if(preg_match("/currency='([[:alpha:]]+)'/", $line, $currencyCode) && preg_match("/rate='([[:graph:]]+)'/", $line, $rate)) {
                //get the iso code (EUR,USD...)
                $ccyCrossId = array_search($currencyCode[1], $this -> currencies);
                if($ccyCrossId && (!in_array($ccyCrossId, $this -> existingRatesForDate))) {
                    $fxrate = new FxRate;
                    $fxrate -> ccy_base_id = 1;
                    $fxrate -> ccy_cross_id = $ccyCrossId;
                    $fxrate -> source = 'ecb-rate';
                    $fxrate -> date = $this -> date;
                    $fxrate -> rate_bid = $rate[1];
                    try {
                        $fxrate -> save();
                    } catch (\Exception $e) {
                        echo $e -> getMessage();
                    }
                }
            }
        }
    }

    /**
     * @return UpdateFxRate
     */
    public function setExistingRatesForDate()
    {
        $this -> existingRatesForDate = FxRate ::where('date', '=', $this -> date) -> where('source', 'ecb-rate') -> get() -> pluck('ccy_cross_id') -> toArray();
        return $this;
    }
}