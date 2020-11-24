<?php

namespace App\Http\Controllers\Setting;

use App\Events\System\DeleteFile;
use App\Events\System\DownloadFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * DownloadController constructor.
     */
    public function __construct()
    {
        $this -> middleware('auth');
    }

    public function downloadFile($module, $id, $fileName)
    {
        $this -> checkAllowAccess('view_document');
        $ds = DIRECTORY_SEPARATOR;
        $website = \Hyn\Tenancy\Facades\TenancyFacade ::website();
        $uuid = $website -> uuid;
        event(new DownloadFile($fileName, $id, $module));
        return Storage ::disk('google') -> download($uuid . $ds . $module . $ds . $id . $ds . $fileName);
    }

    public function deleteFile($module, $id, $fileName)
    {
        $this -> checkAllowAccess('delete_document');

        $ds = DIRECTORY_SEPARATOR;
        $website = \Hyn\Tenancy\Facades\TenancyFacade ::website();
        $uuid = $website -> uuid;

        $deleted = Storage ::disk('google') -> delete($uuid . $ds . $module . $ds . $id . $ds . $fileName);

        if(!$deleted) {
            flash() -> overlay('Error deleting ' . $fileName, 'Error !!') -> message();
        } else {
            event(new DeleteFile($fileName, $id, $module));
            flash() -> overlay('File deleted ' . $fileName, 'Success !!') -> message();
        }
        return back();
    }

    public function sendToLocalAndDownload($file)
    {
        Storage ::disk('file_backup') -> put($file, Storage ::get($file));
    }
}
