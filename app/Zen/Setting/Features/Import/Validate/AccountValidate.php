<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 24/09/2018
 * Time: 15.10
 */

namespace App\Zen\Setting\Features\Import\Validate;


use App\Zen\Setting\Model\Account;

class AccountValidate extends ImportValidate
{

    public function validate($file)
    {
        $validationCheck = $this -> validateFile($file);

        if(!$validationCheck) {
            return ["The format of file is not valid. Please upload file with given formats only." . json_encode($this -> allowedExtension())];
        }

        $collection = $this -> getCollectionFromFile($file);

        $headerCheck = $this -> validateHeader($collection,'account_upload_csv.csv');
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
        $this -> setRowLength(9);

        for($i = 1; $i < count($collection); $i++) {
            if(!array_filter($collection[$i]))
                continue;
            $this -> validateRow($collection[$i], $i);
        }
    }

    public function validateRow($row, $rowNumber)
    {
        $this -> checkRowLength($row, $rowNumber);

        for($i = 0; $i < count($row); $i++) {
            switch($i){
                case 0:
                    $this -> checkBoolean($row[0], $rowNumber, 'Counterparty');
                    break;
                case 1:
                    $this -> checkEmpty($row[1], $rowNumber, 'Account Name');
                    break;
                case 2:
                    $this -> checkNumber($row[2], $rowNumber, 'Client Account Number');
                    $this -> checkUnique($row[2], $rowNumber, 'Client Account Number', 'client_account_number', new Account);
                    break;
                case 3:
                    $this -> checkEmpty($row[3], $rowNumber, 'Client Account Name');
                    break;
                case 4:
                    $this -> checkCurrency($row[4], $rowNumber, 'Currency');
                    break;

                default:
                    break;
            }
        }
    }
}