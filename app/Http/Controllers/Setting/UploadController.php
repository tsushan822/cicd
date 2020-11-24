<?php

namespace App\Http\Controllers\Setting;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Lease\LeaseController;
use App\Zen\Client\Model\Upload;
use App\Zen\Lease\Model\Lease;
use App\Zen\Setting\Features\Import\Upload\LeaseUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function import(Request $request)
    {

        $request -> validate([
            'lease_excel' => 'required'
        ]);
        $excelFile = request() -> file('lease_excel');
        switch($request -> input('submit')){
            case 'submit':
                set_time_limit(20000);
                $this -> checkAllowAccess('import_lease');
                list($extension, $numberOfUploads) = (new LeaseUpload()) -> uploadToDatabase($excelFile);
                flash() -> overlay($numberOfUploads . ' lease(s) are imported from ' . $extension . ' file') -> message();
                return back();
            case 'submit_large':
                try {
                    $fName = md5(rand()) . '.xlsx';
                    $fullPath = Config ::get('filesystems.disks.upload_backup.root');
                    $excelFile -> move($fullPath, $fName);

                    $attr = [
                        'file_name' => $fName,
                        'model' => get_class(new Lease),
                        'user_id' => auth() -> id(),
                    ];
                    Upload ::create($attr);

                } catch (\Exception $e) {
                    return redirect() -> back() -> withErrors($e -> getMessage());
                }

                flash(trans('master.Your file is being processed')) -> message() -> overlay();
                return back();
                break;

            default:
                return back();
                break;
        }
    }
}
