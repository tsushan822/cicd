<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/09/2018
 * Time: 10.15
 */

namespace App\Zen\Setting\Features\Import\Upload;

use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\FxRate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountImport extends ImportContract implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $currencyIso4217 = Currency ::get() -> pluck('id', 'iso_4217_code') -> toArray();
        $counterpartyShortName = Counterparty ::get() -> pluck('id', 'short_name') -> toArray();

        foreach($collection as $row) {
            FxRate ::create([
                'counterparty_id' => $counterpartyShortName[$row['counterparty']],
                'currency_id' => $currencyIso4217[$row['currency']],
                'account_name' => $row['account_name'],
                'iban' => $row['iban'],
                'source' => 'Excel'
            ]);
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
