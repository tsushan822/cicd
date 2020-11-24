<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 05/09/2018
 * Time: 13.46
 */

namespace App\Zen\Report\Library;


use App\Exceptions\CustomException;
use App\Zen\System\Model\Module;
use App\Zen\Report\Model\ReportLibrary;

abstract class UploadCriteriaToDatabase
{

    protected $userId;
    protected $moduleId;
    protected $criteria;
    protected $reportName;
    protected $customReportName;
    protected $route;

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this -> route;
    }

    /**
     * @param mixed $route
     * @return $this
     */
    public function setRoute($route)
    {
        $this -> route = $route;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomReportName()
    {
        return $this -> customReportName;
    }

    /**
     * @param mixed $customReportName
     * @return $this
     */
    public function setCustomReportName($customReportName)
    {
        $this -> customReportName = $customReportName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this -> userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId)
    {
        $this -> userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getModuleId()
    {
        return $this -> moduleId;
    }

    /**
     * @param int $moduleId
     * @return $this
     */
    public function setModuleId(int $moduleId)
    {
        $this -> moduleId = $moduleId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this -> criteria;
    }

    /**
     * @param mixed $criteria
     * @return $this
     */
    public function setCriteria($criteria)
    {
        $this -> criteria = $criteria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReportName()
    {
        return $this -> reportName;
    }

    /**
     * @param mixed $reportName
     * @return $this
     */
    public function setReportName($reportName)
    {
        $this -> reportName = $reportName;
        return $this;
    }

    abstract public function saveReportCriteria();

    protected function setAttributeForDatabase()
    {
        $attr = [
            'module_id' => $this -> getModuleId(),
            'user_id' => $this -> getUserId(),
            'report_name' => $this -> getReportName(),
            'route' => $this -> getRoute(),
            'criteria' => $this -> getCriteria()
        ];
        return $attr;
    }

    protected function uploadToDatabase()
    {
        $attr = $this -> setAttributeForDatabase();
        $reportLibrary = ReportLibrary ::updateOrCreate(['custom_report_name' => $this -> getCustomReportName()], $attr);
        return $reportLibrary;
    }

    /**
     * @param $module
     * @return UploadCriteriaToDatabase
     * @throws CustomException
     */
    public function makeModule($module)
    {
        $moduleObj = Module ::where('name', $module) -> first();

        if($moduleObj instanceof Module)
            return $this -> setModuleId($moduleObj -> id);

        throw new CustomException(trans('master.This module doesn\'t exists.'));
    }

    public function makeCriteria($criteriaItems = [])
    {
        $requestItem = request() -> all();
        $returnArray = [];
        foreach($criteriaItems as $item) {
            if(array_key_exists($item, $requestItem))
                if(is_array($requestItem[$item]) && count($requestItem[$item])) {
                    if(!is_null($requestItem[$item][0]))
                        $returnArray[$item] = $requestItem[$item];
                } else {
                    $returnArray[$item] = $requestItem[$item];
                }
        }
        return $this -> setCriteria(json_encode($returnArray));
    }
}