<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/09/2018
 * Time: 11.43
 */

namespace App\Zen\Setting\Features\Import\Upload;

use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Country;
use App\Zen\Setting\Model\Currency;
use App\Zen\User\Model\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CounterpartyImport extends ImportContract implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $userId= $this -> importFile -> user_id;
        $user= User::find($userId);
        $currencyIso4217 = Currency ::get() -> pluck('id', 'iso_4217_code') -> toArray();
        $countryName = Country ::get() -> pluck('id', 'name') -> toArray();

        foreach($collection as $row) {
           $counterparty= Counterparty ::create([
                'short_name' => $row['short_name'],
                'long_name' => $row['long_name'],
                'is_counterparty' => $row['is_counterparty'],
                'is_entity' => $row['is_entity'],
                'currency_id' => $currencyIso4217[$row['currency']],
                'country_id' => $countryName[$row['country']],
                'ifrs_accounting' => $row['calculate_balance_sheet_values'],
                'lease_rate' => $row['interest_rate'],
                'source' => 'Excel'
            ]);
            if($counterparty -> is_entity){
                $user -> counterparties() -> save($counterparty);
            }

        }

    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 3000;
    }
}
