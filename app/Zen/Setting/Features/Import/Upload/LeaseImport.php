<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 19/09/2018
 * Time: 14.28
 */

namespace App\Zen\Setting\Features\Import\Upload;

use App\Zen\Lease\Calculate\Generate\GenerateLeaseFlow;
use App\Zen\Lease\Calculate\Generate\StoreGeneratedLeaseFlow;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Lease\Service\UploadFromArray;
use App\Zen\Setting\Model\Account;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LeaseImport extends ImportContract implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue, WithEvents
{
    use UploadFromArray;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $this -> uploadIntoDatabase($collection);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 600;
    }
}
