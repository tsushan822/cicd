<?php


namespace App\Zen\Client\Service;


use App\Zen\System\Model\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackUpDatabase
{
    protected $websiteId;

    public function __construct(int $websiteId)
    {
        $this -> websiteId = $websiteId;
    }

    public function backUp()
    {
        $customer = Customer ::with('website') -> where('website_id', $this -> websiteId) -> first();
        $fileName = $this -> backUpTenant($customer);
        $this -> addToOwnFolder($fileName, $customer);
    }

    public function backUpTenant($tenant)
    {
        $dateTime = Carbon ::now() -> format('Ymd-His');
        $database = $tenant -> database;
        $fileName = DIRECTORY_SEPARATOR . $database . '-' .$dateTime. '.zip';
        try {
            $status = Artisan ::call('backup:run', ['--only-db' => 1, '--filename' => $fileName]);
        } catch (\Exception $exception) {
            dump($exception -> getMessage());
        }
        return $fileName;
    }

    public function addToOwnFolder($fileName, $tenant)
    {
        $ds = DIRECTORY_SEPARATOR;
        $alwaysBackUp = $this -> alwaysBackUp($tenant);
        $monthEndBackUp = $this -> checkMonthBackUp($tenant);
        if($alwaysBackUp) {
            Storage :: disk('google') -> move('Backups' . $ds . $fileName, $tenant -> website -> uuid . $ds . 'Database' . $ds . 'Always' . $ds . $fileName);
        } elseif($monthEndBackUp) {
            Storage :: disk('google') -> move('Backups' . $ds . $fileName, $tenant -> website -> uuid . $ds . 'Database' . $ds . 'MonthEnd' . $ds . $fileName);
        } else {
            Storage :: disk('google') -> move('Backups' . $ds . $fileName, $tenant -> website -> uuid . $ds . 'Database' . $ds . $fileName);
        }
    }

    public function checkMonthBackUp($tenant)
    {
        $lastDay = Carbon ::today() -> isLastOfMonth();
        $putMonthEndBackUp = $this -> monthEndAvailable($tenant);
        return $lastDay && $putMonthEndBackUp;

    }

    public function monthEndAvailable($tenant)
    {
        return $tenant -> backUp -> monthly_backup;
    }

    public function alwaysBackUp($tenant)
    {
        return $tenant -> backUp -> always_backup;
    }
}