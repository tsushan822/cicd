<?php


namespace App\Zen\Setting\Service;


use App\Zen\Client\Model\ImportFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{
    /**
     * @param $file
     * @return mixed
     */
    public static function importService($file, $putString = 'Import')
    {
        $path = Storage ::disk('google_la_customer') -> putFile($putString, $file);
        $attr = [
            'user_id' => auth() -> id(),
            'file_name' => $path,
            'start_time' => now(),
        ];
        $importFile = ImportFile ::create($attr);
        return array($path, $importFile);
    }
}