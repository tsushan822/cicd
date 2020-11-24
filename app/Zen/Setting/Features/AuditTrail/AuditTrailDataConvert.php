<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/05/2018
 * Time: 15.18
 */

namespace App\Zen\Setting\Features\AuditTrail;

use App\Zen\Setting\Model\AuditTrail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class AuditTrailDataConvert
{

    use AuditTrailIdToData;

    /**
     * @var
     */
    protected $model;

    public function __construct()
    {

    }

    abstract function finalData($id);

    public function getAuditTrailData($model, $id, $prefix = null)
    {
        $changeObjects = AuditTrail ::where('model', $model) -> filter() -> where('table_id', $id) -> orderBy('created_at', 'desc') -> get();

        return $this -> getAuditTrailDataFunction($changeObjects, $prefix, $model);
    }

    public function getAuditTrailDataAll($model, $id, $prefix = null)
    {
        $changeObjects = AuditTrail ::where('model', $model) -> filter() -> where('table_id', $id) -> orderBy('created_at', 'desc') -> get();

        return $this -> getAuditTrailDataFunction($changeObjects, $prefix, $model);
    }

    public function getAuditTrailDataFunction($changeObjects, bool $prefix = null, string $model = null)
    {
        $returnChanges = [];
        foreach($changeObjects as $change) {
            switch($change -> event){
                case 'updated':
                    $returnChanges = array_merge($returnChanges, $this -> getUpdatedEvent($change, $prefix));
                    break;
                case 'created':
                    $returnChanges[] = $this -> getCreatedEvent($change, $model);
                    if($model == 'LeaseExtension') {
                        $returnChanges = array_merge($returnChanges, $this -> getCreatedEventData($change, true));
                    }
                    break;
                case 'deleted':
                    $returnChanges[] = $this -> getDeletedEvent($change, $prefix);
                    break;
                case 'File Upload':
                case 'File Delete':
                case 'File Download':
                    $returnChanges[] = $this -> getFileAuditTrail($change);
                    break;
                default:
                    $returnChanges[] = $this -> getOtherEvent($change);
                    break;
            }
        }

        return $returnChanges;
    }

    public function getOtherEvent($change)
    {

        $tableId = $change -> table_id;
        $model = $change -> model;
        $changeKey['user'] = $change -> user -> name;
        $changeKey['event'] = $change -> event;
        $changeKey['title'] = $change -> event;
        $changeKey['model'] = $model;
        $changeKey['table_id'] = $tableId;
        $changeKey['time'] = Carbon ::parse($change -> created_at);
        $changeKey['before'] = $change -> before;
        $changeKey['after'] = $change -> after;
        return $changeKey;
    }

    public function getUpdatedEvent($change, $prefix)
    {

        $tableId = $change -> table_id;
        $model = $change -> model;

        $change['user'] = $change -> user -> name;
        $change['time'] = Carbon ::parse($change -> created_at);
        $change['before'] = json_decode($change -> before, true);
        $changesKeys = array_keys($change['before']);
        $change['after'] = json_decode($change -> after, true);

        $j = 0;
        $returnChanges = [];
        foreach($changesKeys as $key) {
            if(!in_array($key, $this -> getNotUpdatableKeys())) {
                $returnChanges[$j]['title'] = $this -> getReadableData($key);
                if($prefix) {
                    $returnChanges[$j]['title'] = $this -> addPrefix($returnChanges[$j]['title'], $model, $tableId);
                }
                $returnChanges[$j]['item'] = $key;
                $returnChanges[$j]['before'] = $change['before'][$key];
                $returnChanges[$j]['after'] = $change['after'][$key];
                $returnChanges[$j]['user'] = $change['user'];
                $returnChanges[$j]['time'] = $change['time'];
                $returnChanges[$j]['model'] = $change -> model;
                $returnChanges[$j]['event'] = ucfirst($change -> event);
                $returnChanges[$j]['table_id'] = $tableId;
            }
            $j++;
        }
        return $returnChanges;
    }

    public function getCreatedEventData($change, $prefix)
    {

        $tableId = $change -> table_id;
        $model = $change -> model;

        $change['user'] = $change -> user -> name;
        $change['time'] = Carbon ::parse($change -> created_at);
        $change['before'] = json_decode($change -> before, true);
        $change['after'] = json_decode($change -> after, true);
        $changesKeys = array_keys($change['after']);

        $j = 0;
        $returnChanges = [];
        foreach($changesKeys as $key) {
            if(!in_array($key, $this -> getNotUpdatableKeys()) && $change['after'][$key] != '0.00') {
                $returnChanges[$j]['title'] = $this -> getReadableData($key);
                if($prefix) {
                    $returnChanges[$j]['title'] = $this -> addPrefix($returnChanges[$j]['title'], $model, $tableId);
                }
                $returnChanges[$j]['item'] = $key;
                $returnChanges[$j]['before'] = null;
                $returnChanges[$j]['after'] = $change['after'][$key];
                $returnChanges[$j]['user'] = $change['user'];
                $returnChanges[$j]['time'] = $change['time'];
                $returnChanges[$j]['model'] = $change -> model;
                $returnChanges[$j]['event'] = ucfirst($change -> event);
                $returnChanges[$j]['table_id'] = $tableId;
            }
            $j++;
        }
        return $returnChanges;
    }

    public function getCreatedEvent($change, $model)
    {
        $tableId = $change -> table_id;
        $model = $change -> model;
        $returnArray = [];

        $returnArray = $this -> addItem($change, $returnArray);
        $returnArray['before'] = '';
        $returnArray['item'] = 'Created';
        $returnArray['after'] = $model . ' ( ' . $tableId . ' ) Created';
        return $returnArray;
    }

    public function getDeletedEvent($change, $prefix)
    {
        $tableId = $change -> table_id;
        $model = $change -> model;
        $returnArray = [];
        $returnArray = $this -> addItem($change, $returnArray);
        $returnArray['before'] = '';
        $returnArray['after'] = $model . ' ( ' . $tableId . ' ) Deleted';
        return $returnArray;
    }

    public function getNotUpdatableKeys()
    {
        return ['updated_at', 'created_at', 'updated_user_id'];
    }

    public function getReadableData($string)
    {
        if(isset($this -> getName()[$string])) {
            return $this -> getName()[$string];
        }
        $returnString = $string;
        $returnString = ucfirst($returnString);
        $returnString = str_replace('_', ' ', $returnString);
        return $returnString;

    }

    public function sortReturnArray($myArray)
    {
        usort($myArray, function ($a, $b) {
            return $a['time'] <=> $b['time'];
        });
        return $myArray;
    }

    public function addPrefix($myArray, $table, $id)
    {
        return '{ ' . $table . ' ID: ' . $id . ' } ' . $myArray;
    }

    /**
     * @param $changes
     * @param Model $model
     * @return array
     * Decrypt the change and only pass those whose values are changed
     */
    public function decryptDataForAuditTrail($changes, string $model = null)
    {
        //Array might have the foreign id
        $array = $this -> columnNameToConvert();
        $newArray = array_column($array, 'foreign_key');

        $resultArray = [];
        foreach($changes as $change) {
            if(strtolower($change['event']) == 'updated' || $model == 'LeaseExtension') {
                if($change['before'] != $change['after']) {
                    if(in_array($change['item'], $newArray)) {
                        $change['before'] = $this -> idToRealData($change['item'], $change['before']);
                        $change['after'] = $this -> idToRealData($change['item'], $change['after']);
                    }
                    $resultArray[] = $change;
                }
            } else {
                $resultArray[] = $change;
            }

        }
        return $resultArray;
    }

    public function fileAuditTrail($model, $id)
    {
        $changeObjects = AuditTrail ::where('model', $model) -> filter() -> where('table_id', $id)
            -> whereIn('event', ['File Upload', 'File Download', 'File Delete']) -> orderBy('created_at', 'desc') -> get();
        $returnArray = [];
        $j = 0;
        foreach($changeObjects as $data) {
            $returnArray[$j++] = $this -> getFileAuditTrail($data);
        }
        return $returnArray;
    }

    public function getFileAuditTrail($data)
    {
        $change['before'] = $data -> before;
        $change['after'] = $data -> after;
        $change = $this -> addItem($data, $change);
        return $change;
    }

    /**
     * @param $data array
     * @param $change
     * @return array
     */
    public function addItem($data, $change)
    {
        $change['event'] = ucfirst($data -> event);
        $change['table_id'] = $data -> table_id;
        $change['time'] = Carbon ::parse($data -> created_at);
        $change['user'] = $data -> user -> name;
        $change['title'] = $data -> event;
        $change['model'] = $data -> model;
        return $change;
    }
}