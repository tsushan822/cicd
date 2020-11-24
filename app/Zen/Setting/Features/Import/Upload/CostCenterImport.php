<?php

namespace App\Zen\Setting\Features\Import\Upload;

use App\Zen\Setting\Model\CostCenter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CostCenterImport extends ImportContract implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
            CostCenter ::create([
                'short_name' => $row['short_name'],
                'long_name' => $row['long_name'],
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
