<?php

namespace App\Zen\Setting\Features\Import\Upload;

use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\FxRate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FxRateImport extends ImportContract implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $currencyIso4217 = Currency ::get() -> pluck('id', 'iso_4217_code') -> toArray();

        foreach($collection as $row) {
            FxRate ::create([
                'date' => Date ::excelToDateTimeObject($row['date']),
                'ccy_base_id' => $currencyIso4217[$row['basecurrency']],
                'ccy_cross_id' => $currencyIso4217[$row['crosscurrency']],
                'rate_bid' => $row['ratebid'],
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
