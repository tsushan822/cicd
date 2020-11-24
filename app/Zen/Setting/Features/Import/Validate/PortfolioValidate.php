<?php


namespace App\Zen\Setting\Features\Import\Validate;

use App\Http\Requests\Setting\StorePortfolioRequest;

class PortfolioValidate extends ImportValidate
{
    protected $portfolioNameArray = [];
    public function validate($file)
    {
        $validationCheck = $this -> validateFile($file);

        if(!$validationCheck) {
            return ["The format of file is not valid. Please upload file with given formats only." . json_encode($this -> allowedExtension())];
        }

        $collection = $this -> getCollectionFromFile($file);

        $headerCheck = $this -> validateHeader($collection, 'portfolio_upload_csv.csv');
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

    public function validateNumberOfRows($collection)
    {
        return count($collection) > 1 && 5002 > count($collection);
    }

    public function validateData($collection)
    {
        $this -> setRowLength(2);

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
                    if(in_array($row[0], $this -> portfolioNameArray)) {
                        $this -> warning[] = trans('master.Portfolio at row already exist in this excel.', ['rowNumber' => $rowNumber]);
                    } else {
                        $this -> portfolioNameArray[] = $row[0];
                    }
                    $this -> checkEmpty($row[0], $rowNumber, 'Name');
                    $attrCheck['name'] = $row[0];
                    break;
                case 1:
                    $this -> checkEmpty($row[1], $rowNumber, 'Long Name');
                    $attrCheck['long_name'] = $row[1];
                    break;

                default:
                    break;
            }
        }
        $message = $this -> checkValidation($attrCheck, $rowNumber, StorePortfolioRequest::class);
        if($message && !count($this -> warning))
            $this -> warning[] = $message;
    }
}