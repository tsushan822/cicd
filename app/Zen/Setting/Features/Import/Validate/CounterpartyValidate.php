<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 27/09/2018
 * Time: 11.44
 */

namespace App\Zen\Setting\Features\Import\Validate;


use App\Http\Requests\Setting\StoreCounterpartyRequest;
use App\Zen\Setting\Model\Counterparty;

class CounterpartyValidate extends ImportValidate
{
    protected $shortNameArray = [];
    protected $longNameArray = [];

    public function validate($file)
    {
        $validationCheck = $this -> validateFile($file);

        if(!$validationCheck) {
            return ["The format of file is not valid. Please upload file with given formats only." . json_encode($this -> allowedExtension())];
        }

        $collection = $this -> getCollectionFromFile($file);

        $headerCheck = $this -> validateHeader($collection, 'company_upload_csv.csv');
        if($headerCheck !== true) {
            return ["Please check you have used exact same file as in file provided. The given file doesn't match our header"];
        }

        $numberValidate = $this -> validateNumberOfRows($collection);

        if(!$numberValidate) {
            return ["Please keep the number of records between 1 and 100."];
        }

        $value = $this -> validateData($collection);

        return $this -> warning;
    }

    public function validateData($collection)
    {
        $this -> setRowLength(17);

        for($i = 1; $i < count($collection); $i++) {
            if(!array_filter($collection[$i]))
                continue;
            $this -> validateRow($collection[$i], $i);
        }
    }

    public function validateRow($row, $rowNumber)
    {
        //$this -> checkRowLength($row, $rowNumber);
        for($i = 0; $i < count($row); $i++) {
            switch($i){
                case 0:
                    if(in_array($row[0], $this -> shortNameArray)) {
                        $this -> warning[] = trans('master.Short name at row already exist in this excel.', ['rowNumber' => $rowNumber]);
                    } else {
                        $this -> shortNameArray[] = $row[0];
                    }
                    $this -> checkEmpty($row[0], $rowNumber, 'Short Name');
                    $this -> checkUnique($row[0], $rowNumber, 'Short Name', 'short_name', new Counterparty);
                    $attr['short_name'] = $row[0];
                    break;

                case 1:
                    if(in_array($row[1], $this -> longNameArray)) {
                        $this -> warning[] = trans('master.Long name at row already exist in this excel.', ['rowNumber' => $rowNumber]);
                    } else {
                        $this -> longNameArray[] = $row[1];
                    }
                    $this -> checkEmpty($row[1], $rowNumber, 'Long Name');
                    $this -> checkUnique($row[1], $rowNumber, 'Long Name', 'long_name', new Counterparty);
                    $attr['long_name'] = $row[1];
                    break;

                case 2:
                    $this -> checkBooleanNotEmpty($row[2], $rowNumber, 'Is Counterparty');
                    $attr['is_counterparty'] = $row[2];
                    break;

                case 3:
                    $this -> checkBooleanNotEmpty($row[3], $rowNumber, 'Is Entity');
                    $attr['is_entity'] = $row[3];
                    break;

                case 4:
                    $attr['currency_id'] = $this -> checkCurrency($row[4], $rowNumber, 'Currency');
                    break;

                case 5:
                    $attr['country_id'] = $this -> checkCountry($row[5], $rowNumber, 'Country');
                    break;

                case 6:
                    $this -> checkBooleanNotEmpty($row[6], $rowNumber, 'Calculate balance sheet values');
                    $attr['ifrs_accounting'] = $row[6];
                    break;

                case 7:
                    $attr['lease_rate'] = $row[6];
                    $this -> checkNumberOrEmpty($row[7], $rowNumber, 'Interest rate');
                    break;

                default:
                    break;
            }
        }
        $message = $this -> checkValidation($attr, $rowNumber, StoreCounterpartyRequest::class);
        if($message)
            $this -> warning[] = $message;
    }
}