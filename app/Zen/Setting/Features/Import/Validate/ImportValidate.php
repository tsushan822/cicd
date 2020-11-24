<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 18/09/2018
 * Time: 14.08
 */

namespace App\Zen\Setting\Features\Import\Validate;


use App\Zen\Setting\Model\Country;
use Cyberduck\LaravelExcel\ImporterFacade as Importer;
use App\Zen\Setting\Model\Account;
use App\Zen\Lease\Model\LeaseType;
use App\Zen\Setting\Model\CostCenter;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\Setting\Model\Currency;
use App\Zen\Setting\Model\Portfolio;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class ImportValidate
{

    protected $accounts;

    protected $entities;

    protected $counterParties;

    protected $costCenters;

    protected $guaranteeTypes;

    protected $leaseTypes;

    protected $currencies;

    protected $countries;

    protected $portfolios;

    protected $tenors;

    protected $warning = [];

    protected $info = [];

    protected $headers = [];

    protected $rowLength;

    public function __construct()
    {
        $this -> setAccounts();
        $this -> setCostCenters();
        $this -> setCurrencies();
        $this -> setCountries();
        $this -> setLeaseTypes();
        $this -> setPortfolios();
        $this -> setEntities();
        $this -> setCounterParties();
        ini_set('max_execution_time', '90');
    }

    abstract public function validate($file);

    public function validateFile($file)
    {
        return $this -> validateExtension($file);
    }

    public function validateHeader($collection, $file)
    {
        return $this -> validateHeaderContents($collection[0], $file);
    }

    public function validateExtension($file)
    {
        $extension = $file -> getClientOriginalExtension();

        return in_array($extension, $this -> allowedExtension());
    }

    public function validateNumberOfRows($collection)
    {
        return count($collection) > 1 && 52 > count($collection);
    }

    public function getCollectionFromFile($file)
    {
        $extension = $file -> getClientOriginalExtension();

        if($extension == 'xls' || $extension == 'xlsx')
            $collection = $this -> getCollectionFromExcelFile($file);

        if($extension == 'csv') {
            //read the entire string
            $str = file_get_contents($file);
            if((substr_count($str, ';') > 5)) {

                //replace something in the file string - this is a VERY simple example
                $str = str_replace(",", ".", $str);
                $str = str_replace(";", ",", $str);

                //write the entire string
                file_put_contents($file, $str);
            }

            $collection = $this -> getCollectionFromCsvFile($file);
        }

        if(!isset($collection))
            throw new \Exception(trans('master.File format not supported'));

        return $collection;

    }

    public function getCollectionFromExcelFile($file)
    {
        return Importer ::make('Excel') -> load($file) -> getCollection();
    }

    public function getCollectionFromCsvFile($file)
    {
        return Importer ::make('Csv') -> load($file) -> getCollection();
    }

    public function makeHeader($collection)
    {
        $headers = array_values($collection[0]);
        $this -> setHeaders($headers);
        return $headers;
    }

    public function allowedExtension()
    {
        return ['xls', 'xlsx'];
    }

    /**
     * @return ImportValidate
     */
    public function setAccounts()
    {
        $accounts = Account ::get() -> pluck('id', 'account_name') -> toArray();
        $this -> accounts = $accounts;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCostCenters()
    {
        $costCenters = CostCenter ::get() -> pluck('id', 'short_name') -> toArray();
        $this -> costCenters = $costCenters;
        return $this;
    }

    /**
     * @return ImportValidate
     */
    public function setLeaseTypes()
    {
        $leaseTypes = LeaseType ::get() -> pluck('id', 'type') -> toArray();
        $this -> leaseTypes = $leaseTypes;
        return $this;
    }

    /**
     * @return ImportValidate
     */
    public function setEntities()
    {
        $entities = Counterparty ::where('is_entity', 1) -> get() -> pluck('id', 'short_name') -> toArray();
        $this -> entities = $entities;
        return $this;
    }

    private function setCounterParties()
    {
        $counterParties = Counterparty ::get() -> pluck('id', 'short_name') -> toArray();
        $this -> counterParties = $counterParties;
        return $this;
    }

    /**
     * @return ImportValidate
     */
    public function setCurrencies()
    {
        $currencies = Currency ::where('active_status', 1) -> get() -> pluck('id', 'iso_4217_code') -> toArray();
        $this -> currencies = $currencies;
        return $this;
    }

    /**
     * @return ImportValidate
     */
    public function setCountries()
    {
        $countries = Country ::get() -> pluck('id', 'name') -> toArray();
        $this -> countries = $countries;
        return $this;
    }

    /**
     * @return ImportValidate
     */
    public function setPortfolios()
    {
        $portfolios = Portfolio ::get() -> pluck('id', 'name') -> toArray();
        $this -> portfolios = $portfolios;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccounts()
    {
        return $this -> accounts;
    }

    /**
     * @return mixed
     */
    public function getCostCenters()
    {
        return $this -> costCenters;
    }

    /**
     * @return mixed
     */
    public function getLeaseTypes()
    {
        return $this -> leaseTypes;
    }

    /**
     * @return mixed
     */
    public function getCurrencies()
    {
        return $this -> currencies;
    }

    /**
     * @return mixed
     */
    public function getPortfolios()
    {
        return $this -> portfolios;
    }

    public function checkEntity($entity, $rowNumber, $column = 'entity')
    {
        if(!array_key_exists($entity, $this -> getEntities()))
            $this -> warning[] = 'The ' . $column . ' ' . $entity . ' at row ' . $rowNumber . ' doesn\'t exist in the system or company is not entity. ';
        else
            return $this -> getEntities()[$entity];

    }

    public function checkCounterparty($counterparty, $rowNumber, $column = 'Counterparty', $info = false)
    {
        if(!array_key_exists($counterparty, $this -> getCounterParties())) {
            if($info) {
                $this -> info[] = 'The ' . $column . ' ' . $counterparty . ' at row ' . $rowNumber . ' doesn\'t exist in the system . It will be created.';
            } else {
                $this -> warning[] = 'The ' . $column . ' ' . $counterparty . ' at row ' . $rowNumber . ' doesn\'t exist in the system . ';
            }
        } else {
            return $this -> getCounterParties()[$counterparty];
        }

    }

    /**
     * @param $portfolio
     * @param $rowNumber
     * @return mixed
     */
    public function checkPortfolio($portfolio, $rowNumber, $info = false)
    {
        if(!array_key_exists($portfolio, $this -> getPortfolios())) {
            if($info) {
                $this -> info[] = 'The portfolio ' . $portfolio . ' at row ' . $rowNumber . ' doesn\'t exist in the system . It will be created.';

            } else {
                $this -> warning[] = 'The portfolio ' . $portfolio . ' at row ' . $rowNumber . ' doesn\'t exist in the system . ';
            }
        } else {
            return $this -> getPortfolios()[$portfolio];

        }
    }

    /**
     * @param $costCenter
     * @param $rowNumber
     * @param string $column
     * @param bool $allowEmpty
     * @return mixed
     */
    public function checkCostCenter($costCenter, $rowNumber, $column = 'CostCenter', $allowEmpty = true, $info = false)
    {
        if($costCenter || $allowEmpty == false) {
            if(!array_key_exists($costCenter, $this -> getCostCenters())) {
                if($info) {
                    $this -> info[] = 'The ' . $column . ' ' . $costCenter . ' at row ' . $rowNumber . ' doesn\'t exist in the system . It will be created';
                } else {
                    $this -> warning[] = 'The ' . $column . ' ' . $costCenter . ' at row ' . $rowNumber . ' doesn\'t exist in the system . ';

                }
            } else {
                return $this -> getCostCenters()[$costCenter];

            }
        }
    }

    /**
     * @param $leaseType
     * @param $rowNumber
     * @return mixed
     */
    public function checkLeaseType($leaseType, $rowNumber)
    {
        if(!array_key_exists($leaseType, $this -> getLeaseTypes()))
            $this -> warning[] = 'The lease type ' . $leaseType . ' at row ' . $rowNumber . ' doesn\'t exist in the system . ';
        else
            return $this -> getLeaseTypes()[$leaseType];
    }

    public function checkUnique($excelRowValue, $rowNumber, $excelRowName, $column, Model $model)
    {
        $exampleTypes = $model ::get() -> pluck('id', $column) -> toArray();
        if(array_key_exists($excelRowValue, $exampleTypes))
            $this -> warning[] = 'The ' . $excelRowName . ' ' . $excelRowValue . ' at row ' . $rowNumber . ' should be unique. 
            Its already in the system.';

    }

    /**
     * @param $currency
     * @param $rowNumber
     * @param string $value
     * @return mixed
     */
    public function checkCurrency($currency, $rowNumber, $value = 'Currency')
    {
        if(!array_key_exists($currency, $this -> getCurrencies()))
            $this -> warning[] = 'The ' . $value . ' ' . $currency . ' at row ' . $rowNumber . ' is inactive or doesn\'t exist in the system. ';
        else
            return $this -> getCurrencies()[$currency];
    }

    /**
     * @param $country
     * @param $rowNumber
     * @param string $value
     * @return mixed
     */
    public function checkCountry($country, $rowNumber, $value = 'Country')
    {
        if(!array_key_exists($country, $this -> getCountries()))
            $this -> warning[] = 'The ' . $value . ' ' . $country . ' at row ' . $rowNumber . ' doesn\'t exist in the system . ';
        else
            return $this -> getCountries()[$country];
    }

    /**
     * @param $account
     * @param $rowNumber
     * @param string $column
     * @return mixed
     */
    public function checkAccount($account, $rowNumber, $column = 'Account')
    {
        if(!array_key_exists($account, $this -> getAccounts()))
            $this -> warning[] = 'The ' . $column . ' ' . $account . ' at row ' . $rowNumber . ' doesn\'t exist in the system . ';
        else
            return $this -> getAccounts()[$account];
    }

    /**
     * @param $account
     * @param $rowNumber
     * @param $currency
     * @return mixed
     */
    public function checkCurrencyAndAccount($account, $rowNumber, $currency)
    {
        try {
            $currencyId = $this -> getCurrencies()[$currency];
            $accountId = $this -> checkAccount($account, $rowNumber);
            $checkAccountCurrency = Account ::where('currency_id', $currencyId) -> where('id', $accountId) -> count();
            if($checkAccountCurrency)
                return true;
            else
                $this -> warning[] = 'The currency doesn\'t match the account currency at row ' . $rowNumber;
        } catch (\Exception $e) {
            $this -> warning[] = 'The currency doesn\'t match the account currency at row ' . $rowNumber;
        }
    }

    /**
     * @param $number
     * @param $rowNumber
     * @param string $column
     * @internal param $account
     */
    public function checkNumber($number, $rowNumber, $column = 'value')
    {
        if(!is_numeric($number))
            $this -> warning[] = 'The ' . $column . $number . ' at row ' . $rowNumber . ' isn\'t the number . ';
    }

    /**
     * @param $number
     * @param $rowNumber
     * @param string $column
     * @internal param $account
     */
    public function checkNumberOrEmpty($number, $rowNumber, $column = 'value')
    {
        if($number)
            $this -> checkNumber($number, $rowNumber, $column);
    }

    /**
     * @param $boolValue
     * @param $rowNumber
     * @param string $column
     */
    public function checkBoolean($boolValue, $rowNumber, $column = 'value')
    {
        if(!($boolValue == 0 || $boolValue == 1))
            $this -> warning[] = 'The ' . $column . $boolValue . ' at row ' . $rowNumber . ' must be 0 and 1 only. ';
    }

    /**
     * @param $boolValue
     * @param $rowNumber
     * @param string $column
     */
    public function checkBooleanNotEmpty($boolValue, $rowNumber, $column = 'value')
    {
        if(!($boolValue === 0 || $boolValue === 1))
            $this -> warning[] = 'The ' . $column . $boolValue . ' at row ' . $rowNumber . ' must be 0 or 1. It cannot be empty';
    }

    /**
     * @param $intValue
     * @param $rowNumber
     * @param string $column
     */
    public function checkMonth($intValue, $rowNumber, $column = 'value')
    {
        if(!($intValue == 1 || $intValue == 2 || $intValue == 3 || $intValue == 4 || $intValue == 6 || $intValue == 12))
            $this -> warning[] = 'The ' . $column . ' ' . $intValue . ' at row ' . $rowNumber . ' must be 2,3,4,6 or 12 only. Value:' . $intValue;
    }

    /**
     * @param $date
     * @param $rowNumber
     * @param string $column
     * @return mixed
     */
    public function checkDate($date, $rowNumber, $column = 'value')
    {
        if($date) {
            if(!is_object($date)) {
                try {
                    Carbon ::createFromFormat('Y-m-d', $date);
                } catch (\Exception $e) {
                    $this -> warning[] = 'The ' . $column . " " . $date . ' at row ' . $rowNumber . ' must be a date with dd/mm/YYYY format. ';
                }
                return Carbon ::createFromFormat('Y-m-d', $date) -> format('Y-m-d');
            } else {
                return $date -> format('Y-m-d');
            }
        } else {
            $this -> checkEmpty($date, $rowNumber, $column);
        }
    }

    /**
     * @param $value
     * @param $rowNumber
     * @param string $column
     * @return mixed
     */
    public function checkEmpty($value, $rowNumber, $column = 'value')
    {
        if(is_null($value)) {
            $this -> warning[] = 'The ' . $column . ' at row ' . $rowNumber . 'cannot be null.';

        }
    }

    /**
     * @param $date
     * @param $rowNumber
     * @param string $column
     * @return mixed
     */
    public function checkDateOrEmpty($date, $rowNumber, $column = 'value')
    {
        if($date) {
            return $this -> checkDate($date, $rowNumber, $column);
        }

        return null;
    }

    /**
     * @param $number
     * @param $rowNumber
     * @param string $column
     */
    public function checkPaymentDay($number, $rowNumber, $column = 'value')
    {
        $paymentDayArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
        if(!in_array($number, $paymentDayArray)) {
            $this -> warning[] = 'The ' . $column . $number . ' at row ' . $rowNumber . ' must be a payment day between 1 and 31. ';
        }
    }

    public function checkRowLength($row, $rowNumber)
    {
        if(!(count($row) == $this -> getRowLength()))
            $this -> warning[] = 'The row  at row number ' . $rowNumber . ' doesn\'t seem to have enough values. It has ' . count($row);
    }

    /**
     * @param array $headers
     * @return ImportValidate
     */
    public function setHeaders(array $headers): ImportValidate
    {
        $this -> headers = $headers;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this -> headers;
    }

    /**
     * @return mixed
     */
    public function getEntities()
    {
        return $this -> entities;
    }

    /**
     * @return mixed
     */
    public function getCounterParties()
    {
        return $this -> counterParties;
    }

    /**
     * @return mixed
     */
    public function getRowLength()
    {
        return $this -> rowLength;
    }

    /**
     * @param mixed $rowLength
     */
    public function setRowLength($rowLength)
    {
        $this -> rowLength = $rowLength;
    }

    /**
     * @return mixed
     */
    public function getCountries()
    {
        return $this -> countries;
    }

    public function validateHeaderContents($header, $fileName)
    {
        $templateHeader = $this -> getTemplateHeader($fileName);

        return $templateHeader == $header;
    }

    public function getTemplateHeader($fileName)
    {
        $file = public_path() . '/Related/Template/' . $fileName;
        $collection = $this -> getCollectionFromCsvFile($file);

        return $collection[0];

    }

    public function checkValidation($data, $rowNumber = null, $formRequest = null)
    {
        if($formRequest) {
            try {
                request() -> merge($data);
                app($formRequest);
                return false;
            } catch (ValidationException $e) {
                $message = $e -> validator -> errors() -> first();
                if($rowNumber) {
                    return $message . ' Make change at row ' . $rowNumber;
                }
                return $message;
            }
        }
        return false;
    }

}