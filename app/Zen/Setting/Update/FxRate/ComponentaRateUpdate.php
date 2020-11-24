<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 02/02/2018
 * Time: 13.32
 */

namespace App\Zen\Setting\Update\FxRate;

use App\Zen\System\Model\MainCurrency;
use App\Zen\System\Model\MainFx as FxRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ComponentaRateUpdate extends UpdateFxRate
{
    public function getSource()
    {
        $file_list = Storage::disk('data_bond')->allFiles();

        $fxRateFileIndex = array_search('fx_' . $this->currentDate() . '.txt', $file_list);

        if(is_numeric($fxRateFileIndex)) {
            $file = json_decode(Storage::disk('data_bond')->get($file_list[$fxRateFileIndex]), true);

            return $file["fx_rates"][0]['data'];
        }
    }


    public function getDate()
    {
        return Carbon::today()->toDateString();
    }

    public function getData()
    {
        if($this->output) {
            foreach($this->output as $rate) {
                $ccyBaseId = array_search($rate["base_currency"], $this->currencies);
                $ccyCrossId = array_search($rate["cross_currency"], $this->currencies);

                if($ccyBaseId && $ccyCrossId) {
                    try {
                        $fxRate = FxRate::UpdateOrCreate([
                            'ccy_base_id' => $ccyBaseId,
                            'ccy_cross_id' => $ccyCrossId,
                            'source' => 'data-bond',
                            'date' => $this->currentDate(),
                            'rate_bid' => $rate["rate_bid"]
                        ]);
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return UpdateFxRate
     */
    public function setExistingRatesForDate()
    {
        $this->existingRatesForDate = FxRate::where('date', '=', $this->date)->where('source', 'ecb-rate')->get()->pluck('ccy_cross_id')->toArray();
        return $this;
    }

    /**
     * change this after getting information
     */

    public function currentDate()
    {
        return today()->format('Ymd');
    }
}
