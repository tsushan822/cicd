<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 08/11/2018
 * Time: 12.15
 */

namespace App\Zen\Setting\Features\Import\Validate;


use App\Http\Requests\Setting\StoreFxRateRequest;

class FxRateValidate extends ImportValidate
{

    public function validate($file)
    {
        $validationCheck = $this -> validateFile($file);

        if(!$validationCheck) {
            return ["The format of file is not valid. Please upload file with given formats only." . json_encode($this -> allowedExtension())];
        }

        $collection = $this -> getCollectionFromFile($file);

        $headerCheck = $this -> validateHeader($collection, 'fxrate_upload_csv.csv');
        if($headerCheck !== true) {
            return ["Please check you have used exact same file as in file provided. The given file doesn't match our header"];
        }

        $numberValidate = $this -> validateNumberOfRows($collection);

        if(!$numberValidate) {
            return ["Please keep the number of records between 1 and 5000."];
        }

        $value = $this -> validateData($collection);

        return $this -> warning;
    }

    public function validateData($collection)
    {
        $this -> setRowLength(5);

        for($i = 1; $i < count($collection); $i++) {
            if(!array_filter($collection[$i]))
                continue;
            $this -> validateRow($collection[$i], $i);
        }
    }

    public function validateRow($row, $rowNumber)
    {
        $this -> checkRowLength($row, $rowNumber);
        $attrCheck = [];
        for($i = 0; $i < count($row); $i++) {
            switch($i){
                case 0:
                    $attrCheck['date'] = $this -> checkDate($row[0], $rowNumber, 'Date');
                    break;
                case 1:
                    $attrCheck['ccy_base_id'] = $this -> checkCurrency($row[1], $rowNumber, 'Base Currency');
                    break;
                case 2:
                    $attrCheck['ccy_cross_id'] = $this -> checkCurrency($row[2], $rowNumber, 'Cross Currency');
                    break;
                case 3:
                    $this -> checkNumber($row[3], $rowNumber, 'Rate Bid');
                    $attrCheck['rate_bid'] = $row[3];
                    break;

                default:
                    break;
            }
        }
        $message = $this -> checkValidation($attrCheck, $rowNumber, StoreFxRateRequest::class);
        if($message)
            $this -> warning[] = $message;
    }

    public function validateNumberOfRows($collection)
    {
        return count($collection) > 1 && 5002 > count($collection);
    }
}