<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/09/2018
 * Time: 16.39
 */

namespace App\Zen\Report\Library;


use App\Zen\Report\Model\ReportLibrary;
use App\Zen\Setting\Features\AuditTrail\AuditTrailIdToData;

class DownloadCriteriaFromDatabase
{
    use AuditTrailIdToData;

    public function index()
    {
        $returnLibraries = ReportLibrary ::all();
        $returnLibraries = $this -> getReadableCriteria($returnLibraries);
        return $returnLibraries;
    }

    public function getReadableCriteria($returnLibraries)
    {
        foreach($returnLibraries as $returnLibrary) {

            $data = $returnLibrary -> criteria;

            $arrayData = json_decode($data, true);

            $returnLibrary -> criteria = $this -> makeReadableCriteriaJson($arrayData);

        }
        return $returnLibraries;
    }

    /**
     * @param $arrayData
     * @return array
     */
    public function makeReadableCriteria($arrayData)
    {
        $returnArray = [];
        foreach($arrayData as $key => $value) {
            if($value != null) {
                list($key, $value) = $this -> convertValueToData($key, $value);
                $returnArray[$key] = $value;
            }
        }
        return $returnArray;
    }


    /**
     * @param $arrayData
     * @return array
     */
    public function makeReadableCriteriaJson($arrayData)
    {
        $returnArray = $this->makeReadableCriteria($arrayData);
        return json_encode($returnArray, JSON_UNESCAPED_UNICODE);
    }

    public function convertValueToData($key, $value)
    {
        $arrayMake = $this -> getName();
        $value = array_key_exists($key, $arrayMake) ? $this -> idToRealData($key, $value) : $value;
        $key = array_key_exists($key, $this -> getNameParent()) ? $this -> getNameParent()[$key] : $key;

        return array($key, $value);
    }

    public function getNameParent()
    {
        $array = $this -> getName();// ::getName();
        $array['start_date'] = 'Start Date';
        $array['end_date'] = 'End Date';
        return $array;
    }
}