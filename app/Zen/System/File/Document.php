<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/02/2018
 * Time: 10.41
 */

namespace App\Zen\System\File;


use App\Events\System\UploadFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class Document
{
    /**
     * @var Model
     */
    private $model;
    private $uuid;

    /**
     * Document constructor.
     * @param Model $model
     */
    public function __construct($model = null)
    {
        $this -> model = $model;
        $website = \Hyn\Tenancy\Facades\TenancyFacade ::website();
        $this -> uuid = $website -> uuid;

    }

    /**
     * @param $fileName
     * Code for uploading the server
     */
    public function upload($fileName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $tableId = $this -> model -> id;
        $model = class_basename($this -> model);
        $pathToUpload = $this -> uuid . $ds . $model . $ds . $tableId;
        $path = $fileName -> storeAs($pathToUpload, $fileName -> getClientOriginalName(), 'google');
        $path = $fileName -> storeAs($pathToUpload.$ds.date('Ymd-His'), $fileName -> getClientOriginalName(), 'google_backup');
        event(new UploadFile($fileName, $tableId, $model));
    }

    public function listFiles()
    {
        $ds = DIRECTORY_SEPARATOR;
        $path = $this -> uuid . $ds . class_basename($this -> model) . $ds . $this -> model -> id;
        $files = collect();
        $files = Storage ::disk('google') -> files($path);
        $i = 0;
        $returnArray = [];
        foreach($files as $file) {
            $extension = pathinfo($file)['extension'];
            $returnArray[$i]['icon'] = $this -> getIcon($extension);
            $returnArray[$i]['date'] = Storage ::disk('google') -> lastModified($file);
            $returnArray[$i]['size'] = Storage ::disk('google') -> size($file);
            $returnArray[$i]['url'] = Storage ::disk('google') -> url($file);
            $returnArray[$i++]['name'] = substr($file, strrpos($file, $ds) + 1);
        }
        return $returnArray;
    }

    public static function setModel($model)
    {
        return new static($model);
    }

    public function getIcon($extension)
    {
        switch($extension){
            case 'pdf':
                return '<i class="fa fa-file-pdf-o" style="color: #ff0000"></i>';
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                return '<i class="fa fa-file-excel-o" style="color: #ff0000"></i>';
                break;
            case 'ppt':
            case 'pptx':
                return '<i class="fa fa-file-powerpoint-o" style="color: #ff0000"></i>';
                break;
            case 'doc':
            case 'docs':
                return '<i class="fa fa-file-word-o" style="color: #ff0000"></i>';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                return '<i class="fa fa-file-image-o" style="color: #ff0000"></i>';
                break;
            case 'zip':
                return ' <i class="fa fa-archive-o" style="color: #ff0000"></i>';
                break;
            default:
                return '<i class="fa fa-file-o" style="color: #ff0000"></i>';
                break;
        }
    }
}