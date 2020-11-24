<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 13/03/2019
 * Time: 13.57
 */

namespace App\Zen\Report\Library\Exports;


use App\Zen\Report\Library\DownloadCriteriaFromDatabase;
use App\Zen\Report\Model\ReportLibrary;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

abstract class ReportExport
{
    /**
     * @var ReportLibrary
     */
    protected $reportLibrary;

    protected $startDate;

    protected $endDate;

    protected $criteria;

    protected $criteriaKey;

    /**
     * GuaranteeReportExport constructor.
     * @param ReportLibrary $reportLibrary
     */
    public function __construct(ReportLibrary $reportLibrary)
    {
        $this -> reportLibrary = $reportLibrary;

        $this -> extendingRequest();

        $this -> overrideTheDates();

    }

    public function makeCriteria()
    {
        $result = $this -> overrideWithRequest();
        $criteria = (new DownloadCriteriaFromDatabase()) -> makeReadableCriteria($result);
        return $criteria;
    }

    public function overrideWithRequest()
    {
        $data = $this -> reportLibrary -> criteria;
        $arrayData = json_decode($data, true);
        foreach($arrayData as $key => $value) {
            if(array_key_exists($key, request() -> all()))
                $arrayData[$key] = request() -> get($key);
        }
        return $arrayData;
    }

    public function overrideTheDates()
    {
        $this -> overrideTheStartDate();

        $this -> overrideTheEndDate();

        return $this;
    }

    public function overrideTheStartDate()
    {
        if(request() -> start_date_new)
            request() -> merge([$this -> getStartDate() => request() -> start_date_new]);
    }

    public function overrideTheEndDate()
    {
        if(request() -> end_date_new)
            request() -> merge([$this -> getEndDate() => request() -> end_date_new]);
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this -> startDate ?: 'start_date';
    }

    /**
     * @param mixed $startDate
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this -> startDate = $startDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this -> endDate ?: 'end_date';
    }

    /**
     * @param mixed $endDate
     * @return $this
     */
    public function setEndDate($endDate)
    {
        $this -> endDate = $endDate;
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
     */
    public function setCriteria($criteria)
    {
        $this -> criteria = $criteria;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [];
    }

    public function numberFormat()
    {
        return NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1;
    }

    public function extendingRequest(): void
    {
        $reportLibrary = json_decode($this -> reportLibrary -> criteria, true);

        $criteriaArray = $this -> setCriteriaKey();

        //Strip out all request parameter for bulk request library
        foreach($criteriaArray as $item) {
            request() -> merge([$item => null]);
        }

        request() -> merge($reportLibrary);
    }

    public function setCriteriaKey()
    {
        return ['entity_id', 'counterparty_id', 'instrument_id', 'currency_id',
            'portfolio_id', 'cost_center_id','lease_type_id','fx_type_id'];
    }

}