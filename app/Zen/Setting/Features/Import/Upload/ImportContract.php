<?php


namespace App\Zen\Setting\Features\Import\Upload;


use App\Zen\Client\Model\ImportFile;
use Illuminate\Support\Facades\Log;
use Laravel\Spark\Announcement;
use Laravel\Spark\Notification;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Ramsey\Uuid\Uuid;

class ImportContract
{

    /**
     * ImportContract constructor.
     * @param ImportFile $importFile
     */
    public function __construct(ImportFile $importFile)
    {
        ini_set('max_execution_time', '1200');
        $this -> importFile = $importFile;
    }

    public function registerEvents(): array
    {
        $body = implode(" ",preg_split('/(?=[A-Z])/',(new \ReflectionClass($this)) -> getShortName()));
        $announcementAttr = [
            'user_id' => $this -> importFile -> user_id,  
        ];
        return [
            ImportFailed::class => function (ImportFailed $event) use($announcementAttr, $body){
                $announcementAttr['body'] =  $body . ' failed';
                $announcementAttr['action_text'] = 'Import failed';
                Log ::critical('Failed importing: ' . $event -> e -> getMessage());
                Notification::create($announcementAttr);
                //$this->importedBy->notify(new ImportHasFailedNotification);
            },

            AfterImport::class => function (AfterImport $event) use($announcementAttr, $body){
                $this -> importFile -> end_time = now();
                $announcementAttr['body'] =  $body . ' succeded';
                $announcementAttr['action_text'] = 'Import succeded';
                $this -> importFile -> save();
                Notification::create($announcementAttr);
            },

        ];
    }
}