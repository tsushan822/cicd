<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 18/09/2018
 * Time: 14.11
 */

namespace App\Zen\Setting\Features\Import\Validate;

use App\Http\Requests\Lease\StoreLeaseRequest;
use App\Zen\System\Model\Module;
use App\Zen\Lease\Model\Lease;
use App\Zen\System\Model\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaseValidate extends ImportValidate
{

    public function validate($file)
    {

        $validationCheck = $this -> validateFile($file);

        if(!$validationCheck) {
            return [["The format of file is not valid. Please upload file with given formats only." . json_encode($this -> allowedExtension())], $this -> info];
        }

        $collection = $this -> getCollectionFromFile($file);

        $headerCheck = $this -> validateHeader($collection, 'lease_upload_csv.csv');
        if($headerCheck !== true) {
            return [["Please check you have used exact same file as in file provided. The given file doesn't match our header"], $this -> info];
        }

        $numberValidate = $this -> validateNumberOfRows($collection);

        if(!$numberValidate) {
            return [["You can upload only " . $this -> numberOfPossibleLease() . ' leases according to your current subscription plan. But you are trying to upload ' . (count($collection) - 1) . ' leases.'], $this -> info];
        }

        $value = $this -> validateData($collection);

        return [$this -> warning, $this -> info];
    }

    public function validateNumberOfRows($collection)
    {

        return count($collection) > 1 && $this -> numberOfPossibleLease() >= count($collection);
    }

    public function validateData($collection)
    {
        $this -> setRowLength(27);

        for($i = 1; $i < count($collection); $i++) {
            if(!array_filter($collection[$i]))
                continue;
            $this -> validateRow($collection[$i], $i);
        }
    }

    public function validateRow($row, $rowNumber)
    {
        $this -> checkRowLength($row, $rowNumber);
        $attr = [];
        for($i = 0; $i < count($row); $i++) {
            switch($i){
                case 0:
                    $entityId = $this -> checkEntity($row[0], $rowNumber);
                    $attr['entity_id'] = $entityId;
                    break;
                case 1:
                    $counterpartyId = $this -> checkCounterparty($row[1], $rowNumber, 'Company', true);
                    $attr['counterparty_id'] = $counterpartyId ?: $row[1] ?: null;
                    break;
                case 2:
                    $attr['customer_reference'] = $row[2];
                    break;
                case 3:
                    $leaseTypeId = $this -> checkLeaseType($row[3], $rowNumber);
                    $attr['lease_type_id'] = $leaseTypeId;
                    break;

                case 4:
                    $portfolioId = $this -> checkPortfolio($row[4], $rowNumber, true);
                    $attr['portfolio_id'] = $portfolioId ?: $row[4] ?: null;
                    break;

                case 5:
                    $costCenterId = $this -> checkCostCenter($row[5], $rowNumber, 'CostCenter', true, true);
                    $attr['cost_center_id'] = $costCenterId;
                    break;

                case 6:
                    $this -> checkNumberOrEmpty($row[6], $rowNumber, 'Interest rate applied for the lease');
                    $attr['lease_rate'] = $row[6];
                    break;

                case 7:
                    $this -> checkNumber($row[7], $rowNumber, '*Fixed Asset Lease amount');
                    $attr['lease_amount'] = $row[7];
                    break;

                case 8:
                    $this -> checkNumberOrEmpty($row[8], $rowNumber, 'Services included in lease');
                    $attr['lease_service_cost'] = $row[8] ?: 0;
                    break;

                case 9:
                    $currencyId = $this -> checkCurrency($row[9], $rowNumber);
                    $attr['currency_id'] = $currencyId;
                    break;

                case 10:
                    $date = $this -> checkDate($row[10], $rowNumber);
                    $attr['effective_date'] = $date;
                    break;

                case 11:
                    $date = $this -> checkDate($row[11], $rowNumber);
                    $attr['maturity_date'] = $date;
                    break;

                case 12:
                    $date = $this -> checkDateOrEmpty($row[12], $rowNumber);
                    $attr['contractual_end_date'] = $date;
                    break;

                case 13:
                    $date = $this -> checkDate($row[13], $rowNumber);
                    $attr['first_payment_date'] = $date;
                    break;

                case 14:
                    $this -> checkPaymentDay($row[14], $rowNumber, "*Future payment dates within a month");
                    $attr['payment_day'] = $row[14];
                    break;

                case 15:
                    $this -> checkNumberOrEmpty($row[15], $rowNumber, 'Exercise price of a purchase option');
                    $attr['exercise_price'] = $row[15] ?: 0;
                    break;

                case 16:
                    $this -> checkNumberOrEmpty($row[16], $rowNumber, 'Residual value guarantee');
                    $attr['residual_value_guarantee'] = $row[16] ?: 0;
                    break;

                case 17:
                    $this -> checkNumberOrEmpty($row[17], $rowNumber, 'Penalties for terminating the lease');
                    $attr['penalties_for_terminating'] = $row[17] ?: 0;
                    break;

                case 18:
                    $this -> checkNumberOrEmpty($row[18], $rowNumber, 'Lease Payments made on or before commencement date');
                    $attr['payment_before_commencement_date'] = $row[18] ?: 0;
                    break;

                case 19:
                    $this -> checkNumberOrEmpty($row[19], $rowNumber, 'Initial direct cost');
                    $attr['initial_direct_cost'] = $row[19] ?: 0;
                    break;

                case 20:
                    $this -> checkNumberOrEmpty($row[20], $rowNumber, 'Estimated cost for dismantling restoring asset');
                    $attr['cost_dismantling_restoring_asset'] = $row[20] ?: 0;
                    break;

                case 21:
                    $this -> checkNumberOrEmpty($row[21], $rowNumber, 'Lease Incentives Received');
                    $attr['lease_incentives_received'] = $row[21] ?: 0;
                    break;

                case 22:
                    $this -> checkNumberOrEmpty($row[22], $rowNumber, 'Residual value');
                    $attr['residual_value'] = $row[22] ?: 0;
                    break;

                case 27:
                    $this -> checkMonth($row[27], $rowNumber, "*Payments per year");
                    $attr['lease_flow_per_year'] = $row[27];
                    break;

                default:
                    break;
            }
        }

        if(count($this -> warning))
            return;

        $message = $this -> checkValidation($attr, $rowNumber, StoreLeaseRequest::class);
        if($message)
            $this -> warning[] = $message;
    }

    private function numberOfPossibleLease()
    {
        if(app('websiteId')) {
            $customer = Customer ::where('website_id', app('websiteId')) -> first();
            $module = Module ::where(['customer_id' => $customer -> id, 'name' => 'Lease']) -> first();
            return $module -> available_number - Lease ::count();
        }
        return 502;

        //Check according to plan
        // if based on plan send number of available plan message.
    }

}