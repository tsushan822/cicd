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
use SoapClient;

class RiksBankRateUpdate extends UpdateFxRate
{

    public function getData()
    {
        if($this -> date === $this -> output['return']['groups']['series'][0]['resultrows']['date']) {

            foreach($this -> output['return']['groups']['series'] as $row) {

                $ccyCrossId = array_search(substr($row['seriesid'], 3, 3), $this -> currencies);
                if($ccyCrossId && (!in_array($ccyCrossId, $this -> existingRatesForDate))) {
                    $fxrate = new Fxrate;
                    $fxrate -> ccy_base_id = 6;
                    $fxrate -> ccy_cross_id = $ccyCrossId;
                    $fxrate -> direct_quote = 0;
                    $fxrate -> date = $this -> date;
                    $fxrate -> source = 'riksbank';
                    $rateBid = $row['resultrows']['value'] / $row['unit'];
                    $fxrate -> rate_bid = 1 / $rateBid;
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
     * @return mixed
     * @throws \SoapFault
     */
    public function getSource()
    {
        $client = new SoapClient('https://swea.riksbank.se/sweaWS/wsdl/sweaWS_ssl.wsdl', array('soap_version' => SOAP_1_2));

        $getLatestInterestAndExchangeRatesParameters = array(
            'languageid' => 'en',
            'seriesid' => array('SEKAUDPMI', 'SEKBRLPMI', 'SEKCADPMI', 'SEKCHFPMI', 'SEKCNYPMI', 'SEKCZKPMI', 'SEKDKKPMI', 'SEKEURPMI', 'SEKGBPPMI', 'SEKHKDPMI', 'SEKHUFPMI', 'SEKIDRPMI', 'SEKINRPMI', 'SEKISKPMI', 'SEKJPYPMI', 'SEKKRWPMI', 'SEKMADPMI', 'SEKMXNPMI', 'SEKNOKPMI', 'SEKNZDPMI', 'SEKPLNPMI', 'SEKRUBPMI', 'SEKSARPMI',
                'SEKSGDPMI', 'SEKTHBPMI', 'SEKTRYPMI', 'SEKUSDPMI', 'SEKZARPMI'));
        $sourceJson = response() -> json($client -> getLatestInterestAndExchangeRates($getLatestInterestAndExchangeRatesParameters));

        $sourceArray = json_decode($sourceJson -> content(), true);

        return $sourceArray;

    }

    public function setExistingRatesForDate()
    {
        $this -> existingRatesForDate = FxRate ::where('date', '=', $this -> date) -> where('source', 'riksbank')
            -> get() -> pluck('ccy_cross_id') -> toArray();
    }

    public function getDate()
    {
        return Carbon ::today() -> toDateString();
    }
}