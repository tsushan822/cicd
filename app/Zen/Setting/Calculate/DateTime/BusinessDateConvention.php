<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 06/07/2018
 * Time: 11.44
 */

namespace App\Zen\Setting\Calculate\DateTime;


use App\Exceptions\CustomException;
use App\Zen\Setting\Model\BusinessDayConvention;
use Carbon\Carbon;

class BusinessDateConvention
{
    public function convertDateWithBusinessDayConvention(BusinessDayConvention $convention = null, $date)
    {
        //if weekdays
        if($this -> checkIfBusinessDay($date))
            return $date;
        if(!$convention)
            $convention = BusinessDayConvention ::first();
        //if weekend
        switch($convention -> convention){
            case 'No Adjustment':
                $returnDate = $this -> noAdjustment($date);
                break;

            case 'Previous':
                $returnDate = $this -> previousBusinessDay($date);
                break;

            case 'Following':
                $returnDate = $this -> nextBusinessDay($date);
                break;

            case 'Modified Previous':
                $returnDate = $this -> modifiedPrevious($date);
                break;

            case 'Modified Following':
                $returnDate = $this -> modifiedFollowing($date);
                break;

            case 'End of Month - No Adjustment':
                $returnDate = $this -> endOfMonthNoAdjustment($date);
                break;

            case 'End of Month - Previous':
                $returnDate = $this -> endOfMonthPrevious($date);
                break;

            case 'End of Month - Following':
                $returnDate = $this -> endOfMonthFollowing($date);;
                break;

            default:
                throw new CustomException(trans('master.Add Day count convention'));
        }
        return $returnDate;
    }

    public function noAdjustment($date)
    {
        return $date;
    }

    public function previous($date)
    {
        return $this -> previousBusinessDay($date);
    }

    public function following($date)
    {
        return $this -> nextBusinessDay($date);

    }

    public function modifiedPrevious($date)
    {
        $returnDate = $this -> previousBusinessDay($date);
        if(Carbon ::parse($date) -> format('m') != Carbon ::parse($returnDate) -> format('m')) {
            $returnDate = $this -> nextBusinessDay($date);
        }
        return $returnDate;

    }

    public function modifiedFollowing($date)
    {
        $returnDate = $this -> nextBusinessDay($date);
        if(Carbon ::parse($date) -> format('m') != Carbon ::parse($returnDate) -> format('m')) {
            $returnDate = $this -> previousBusinessDay($date);
        }
        return $returnDate;
    }

    public function endOfMonthNoAdjustment($date)
    {
        return Carbon ::parse($date) -> endOfMonth() -> toDateString();
    }

    public function endOfMonthPrevious($date)
    {
        $returnDate = Carbon ::parse($date) -> endOfMonth() -> toDateString();
        if(!$this -> checkIfBusinessDay($returnDate)) {
            $returnDate = $this -> previousBusinessDay($returnDate);
        }
        return $returnDate;

    }

    public function endOfMonthFollowing($date)
    {
        $returnDate = Carbon ::parse($date) -> endOfMonth() -> toDateString();
        if(!$this -> checkIfBusinessDay($returnDate)) {
            $returnDate = $this -> nextBusinessDay($returnDate);
        }
        return $returnDate;
    }

    public function nextBusinessDay($date)
    {
        $returnDate = Carbon ::parse($date) -> nextWeekday() -> toDateString();
        if($this -> checkIfHoliday($returnDate)) {
            $this -> nextBusinessDay($returnDate);
        }
        return $returnDate;
    }

    public function previousBusinessDay($date)
    {
        $returnDate = Carbon ::parse($date) -> previousWeekday() -> toDateString();
        if($this -> checkIfHoliday($returnDate)) {
            $this -> previousBusinessDay($returnDate);
        }
        return $returnDate;
    }

    public function checkIfBusinessDay($date)
    {
        if(Carbon ::parse($date) -> isWeekday() && !$this -> checkIfHoliday($date))
            return true;

        return false;
    }

    public function checkIfHoliday($date)
    {
        return false;
    }
}