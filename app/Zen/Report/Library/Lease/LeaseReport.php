<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 07/09/2018
 * Time: 11.22
 */

namespace App\Zen\Report\Library\Lease;


use App\Zen\Report\Library\UploadCriteriaToDatabase;

class LeaseReport extends UploadCriteriaToDatabase
{

    public function saveReportCriteria()
    {
        $this -> checkCriteria();

        return $this -> uploadToDatabase();
    }



    protected function checkCriteria()
    {
        return true;
    }
}