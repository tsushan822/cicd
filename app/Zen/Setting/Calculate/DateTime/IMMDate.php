<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 30/07/2018
 * Time: 10.57
 */

namespace App\Zen\Setting\Calculate\DateTime;


use Carbon\Carbon;

class IMMDate
{
    public function gettingIMMDate($startDate, $endDate)
    {
        $returnArray = array();
        $month = date('n', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        if($month != 3 && $month != 6 && $month != 9 && $month != 12) {
            list($month, $year) = $this -> adjustDateIMM($month, $year);
        } else {
            if($startDate > $this -> getStartDateIMM($month, $year))
                list($month, $year) = $this -> adjustDateIMM($month, $year);
        }
        $startDate = $this -> getStartDateIMM($month, $year);

        while($startDate <= $endDate) {

            $returnArray[] = $startDate;
            $month = date('n', strtotime($startDate));
            $year = date('Y', strtotime($startDate));
            list($month, $year) = $this -> adjustDateIMM($month, $year);
            $startDate = $this -> getStartDateIMM($month, $year);

        }
        return $returnArray;
    }

    private function adjustDateIMM($month, $year)
    {

        switch($month){
            case 12:
                $returnValue = array(3, $year + 1);
                break;
            case 1:
            case 2:
                $returnValue = array(3, $year);
                break;

            case 3:
            case 4:
            case 5:
                $returnValue = array(6, $year);
                break;

            case 7:
            case 8:
            case 6:
                $returnValue = array(9, $year);
                break;

            case 9:
            case 10:
            case 11:
                $returnValue = array(12, $year);
                break;

            default:
                $returnValue = array(3, $year);
        }
        return $returnValue;
    }

    private function getStartDateIMM($month, $year)
    {
        $dateGet = 'third Wednesday of ' . number_to_month($month) . ' ' . $year;
        $startDate = Carbon ::parse($dateGet) -> toDateString();
        return $startDate;
    }
}