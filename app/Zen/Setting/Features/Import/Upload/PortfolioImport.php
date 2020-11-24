<?php

namespace App\Zen\Setting\Features\Import\Upload;

use App\Zen\Setting\Model\Portfolio;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PortfolioImport extends ImportContract implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
            Portfolio ::create([
                'name' => $row['name'],
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
