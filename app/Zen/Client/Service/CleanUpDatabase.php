<?php

namespace App\Zen\Client\Service;

use App\Zen\System\Model\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class CleanUpDatabase
{
    private $websiteId;

    /**
     * CleanUpDatabase constructor.
     * @param int $websiteId
     */
    public function __construct(int $websiteId)
    {
        $this -> websiteId = $websiteId;
    }

    public function cleanUp()
    {
        $customer = Customer ::with('website') -> where('website_id', $this -> websiteId) -> first();
        $this -> cleanBackUpTenant($customer);
        return;
    }

    /**
     * @param $tenant
     * @return void
     */
    public function cleanBackUpTenant($tenant)
    {

        $dailyBackUpDays = $this -> dailyBackUpDays($tenant);
        $toBeDeletedDate = Carbon ::parse() -> subDays($dailyBackUpDays) -> toDateString();

        $files = Storage ::disk('google') -> files($tenant -> website -> uuid . '/Database');
        foreach($files as $file) {
            $this -> checkAndDelete($file, $toBeDeletedDate);
        }

    }

    public function checkAndDelete($file, $toBeDeletedDate)
    {
        $modifiedTime = Storage ::disk('google') -> lastModified($file);
        $modifiedTime = Carbon ::createFromTimestamp($modifiedTime) -> toDateString();
        if($modifiedTime < $toBeDeletedDate) {
            $this -> deleteFile($file);
        }

    }

    public function deleteFile($file)
    {
        Storage ::disk('google') -> delete($file);
    }

    public function dailyBackUpDays($tenant)
    {
        return $tenant -> backUp -> backup_days;
    }

}