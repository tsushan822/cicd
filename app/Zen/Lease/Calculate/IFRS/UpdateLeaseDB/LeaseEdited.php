<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 17/05/2018
 * Time: 16.49
 */

namespace App\Zen\Lease\Calculate\IFRS\UpdateLeaseDB;


use App\Exceptions\CustomException;
use App\Zen\Lease\Calculate\IFRS\LeaseDiscount;
use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Model\LeaseExtension;
use App\Zen\Lease\Model\LeaseFlow;
use App\Zen\Lease\Service\LeaseExtensionService;
use App\Zen\Lease\Service\LeaseFlowService;
use App\Zen\Lease\Service\MonthEndConversionService;
use App\Zen\Setting\Calculate\Generate\GenerateFlow;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

abstract class LeaseEdited extends GenerateFlow
{
    /**
     * @var Lease
     */
    protected $lease;
    protected $extensionId;

    /**
     * LeaseEdited constructor.
     * @param Lease $lease
     */
    public function __construct(Lease $lease)
    {
        $this -> lease = $lease;
    }

    abstract function updateLeaseFlows();

    abstract function updateDepreciation();

    abstract function updateLiability();

    abstract function getLeaseFlows();

    public function updateLeaseLiability($leaseFlows, $openingBalance)
    {
        if($this -> lease -> lease_flow_per_year == 12 && $this -> lease -> leaseType -> payment_type == 'Advance' && $this -> lease -> leaseType -> exclude_first_payment) {
            foreach($leaseFlows as $leaseFlow) {
                $leaseFlow -> interest_cost = (new LeaseDiscount($this -> lease)) -> calculateInterest($leaseFlow, $openingBalance - $leaseFlow -> fixed_payment);
                $leaseFlow -> liability_opening_balance = $openingBalance;
                $leaseFlow -> liability_closing_balance = $leaseFlow -> liability_opening_balance + $leaseFlow -> interest_cost - $leaseFlow -> fixed_payment;
                $openingBalance = $leaseFlow -> liability_closing_balance;
                $leaseFlow -> save();
            }
        } else {
            foreach($leaseFlows as $leaseFlow) {
                $leaseFlow -> interest_cost = (new LeaseDiscount($this -> lease)) -> calculateInterest($leaseFlow, $openingBalance);
                $leaseFlow -> liability_opening_balance = $openingBalance;
                $leaseFlow -> liability_closing_balance = $leaseFlow -> liability_opening_balance + $leaseFlow -> interest_cost - $leaseFlow -> fixed_payment;
                $openingBalance = $leaseFlow -> liability_closing_balance;
                $leaseFlow -> save();
            }

        }

    }

    public function amountOfDepreciation($lease, $depreciationOpeningBalance = 0)
    {
        (new UpdateDepreciationValues($lease)) -> updateDepreciation($depreciationOpeningBalance);
    }

    public function updateLeaseFlowExtension($lease, $endDate = null)
    {
        if($endDate) {
            request() -> request -> add(['extension_end_date' => $endDate]);
        }
        $extensionStartDate = Carbon ::parse(request() -> extension_start_date) -> toDateString();
        $dateOfChange = Carbon ::parse(request() -> date_of_change) -> toDateString();
        $previousLeaseFlow = LeaseFlowService ::previousLeaseFlowNoDepreciationBeforeDate($lease, $dateOfChange);
        $startDate = $previousLeaseFlow -> end_date;
        $leaseFlowsDeleted = LeaseFlowService ::deleteLeaseFlow($lease -> id, $dateOfChange);
        $requestEndDate = request() -> input('extension_end_date');
        $paymentDate = Carbon ::parse($startDate) -> addMonthsNoOverflow(12 / $lease -> lease_flow_per_year) -> endOfMonth() -> toDateString();
        //If the payment date is greater than passed end date don't proceed
        if($paymentDate > $requestEndDate) {
            return 1;
        }
        request() -> request -> add(['user_id' => Auth ::id(), 'lease_id' => $lease -> id]);

        $leaseExtension = LeaseExtension ::create(request() -> all());

        $this -> setExtensionId($leaseExtension -> id);
        $this -> addLeaseFlow($lease, $paymentDate, $requestEndDate, $extensionStartDate, $startDate, $leaseExtension);
    }

    /**
     * @param $lease
     * @param $paymentDate
     * @param $requestEndDate
     * @param $extensionStartDate
     * @param $startDate
     * @param $leaseExtension
     * @return Collection
     */
    public function addLeaseFlow($lease, $paymentDate, $requestEndDate, $extensionStartDate, $startDate, $leaseExtension)
    {
        $leaseFlows = [];
        $leasePaymentAmount = 0;
        $leaseServiceAmount = 0;
        $previousExtension = LeaseExtensionService ::earlierExtension($leaseExtension -> id);
        while ($startDate < $requestEndDate) {
            $attr = [];
            if($paymentDate < $extensionStartDate) {
                $leasePaymentAmount = $previousExtension -> extension_period_amount;
                $leaseServiceAmount = $previousExtension -> extension_service_cost;
            } else {
                $leasePaymentAmount = request() -> extension_period_amount;
                $leaseServiceAmount = request() -> extension_service_cost;
            }

            $endDate = $requestEndDate < $paymentDate ? $requestEndDate : $paymentDate;
            $payDate = LeaseFlowService ::updatePaymentDay($endDate, $lease);
            $attr = $this -> fixedAmountValue($payDate, $attr, $leasePaymentAmount, $leaseServiceAmount, $leaseExtension);

            $endDate = $requestEndDate < $paymentDate ? $requestEndDate : $paymentDate;
            $attr['lease_id'] = $lease -> id;
            $attr['user_id'] = Auth ::id();
            $attr['account_id'] = $lease -> account_id;
            $attr['end_date'] = $endDate;
            $attr['payment_date'] = $payDate;
            $attr['start_date'] = $startDate;
            $attr['lease_extension_id'] = $leaseExtension -> id;

            $leaseFlows[] = $attr;
            $startDate = $paymentDate;
            $paymentDate = Carbon ::parse($startDate) -> addMonthsNoOverflow(12 / $lease -> lease_flow_per_year)
                -> endOfMonth() -> toDateString();
        }


        if(count($leaseFlows)) {
            $leasePaymentAmounts['fixed_amount'] = $leasePaymentAmount;
            $leasePaymentAmounts['fees'] = $leaseServiceAmount;
            $leaseFlows = $this -> leaseFlowInfo($leaseFlows, $leasePaymentAmounts);

            $leaseFlows = $this -> checkPaymentType($leaseFlows);

            $this -> addLeaseFlowToDb($leaseFlows, $leaseExtension);
        }

    }

    public function leaseFlowInfo($leaseFlows, $leasePaymentAmounts)
    {
        $priceIncreaseInterval = request() -> input('price_increase_interval');
        $dateOfFirstPriceIncrease = request() -> input('date_of_first_price_increase');
        $extraPaymentInFees = $this -> lease -> leaseType -> extra_payment_in_fees;
        if(round(request() -> input('negotiate_price_increase_percent'))) {
            $leaseFlows = $this -> addExtraPaymentPercent($dateOfFirstPriceIncrease, $leaseFlows, $leasePaymentAmounts,
                request() -> input('negotiate_price_increase_percent'), $priceIncreaseInterval, $extraPaymentInFees);
        } elseif(round(request() -> input('negotiate_price_increase_amount'))) {
            $leaseFlows = $this -> addExtraPaymentAmount($dateOfFirstPriceIncrease, $leaseFlows, $leasePaymentAmounts,
                request() -> input('negotiate_price_increase_amount'), $priceIncreaseInterval);
        }
        return $leaseFlows;
    }

    public function addLeaseFlowToDb($leaseFlows, $leaseExtension)
    {
        $i = 1;
        if($this -> lease -> lease_flow_per_year == 12 && $this -> lease -> leaseType -> payment_type == 'Advance' && $this -> lease -> leaseType -> exclude_first_payment)
            $i = 0;
        foreach($leaseFlows as $leaseFlow) {
            $leaseFlow['fixed_payment'] = $leaseFlow['fixed_amount'];
            $parameter['fixed_amount'] = $leaseFlow['fixed_amount'];
            $parameter['start_date'] = Carbon ::parse($leaseExtension -> date_of_change) -> subDay() -> toDateString();
            $parameter['end_date'] = $leaseFlow['end_date'];
            $discountedInstrument = (new LeaseDiscount($this -> lease)) -> calculateValue($leaseExtension -> lease_extension_rate, $parameter, $i++, $this -> lease -> lease_flow_per_year);
            $leaseFlow['variations'] = $discountedInstrument;
            $leaseFlow['total_payment'] = $leaseFlow['fixed_payment'] + $leaseFlow['fees'];

            LeaseFlow ::create($leaseFlow);
        }
    }

    /**
     * Passing the last lease flow of previous extension
     * Passing the current extension
     * @param $lastFlow
     * @param $leaseExtension
     * @return float
     * @throws CustomException
     * Since the depreciation is on month basis, that depreciation is so adjusted
     */
    public function lastDepreciationCalculation($lastFlow, $leaseExtension)
    {
        if(!$lastFlow)
            throw new CustomException(trans('master.No last flow found'));

        $paymentsPerYear = $lastFlow -> lease -> lease_flow_per_year;
        if($paymentsPerYear == 12) {
            return $lastFlow -> depreciation_closing_balance / $paymentsPerYear * 12;
        }
        //Last depreciation divide by month interval of installment
        $lastClosing = $lastFlow -> depreciation_closing_balance;
        $monthDepreciation = LeaseFlowService ::monthDepreciationWithMonth($lastFlow);
        $dateOfChange = $leaseExtension -> date_of_change;
        $diffInMonths = Carbon ::parse($lastFlow -> end_date) -> diffInMonths($dateOfChange);
        return $lastClosing - ($monthDepreciation * $diffInMonths);
    }

    /**
     *
     */
    public function updateConversionRate()
    {
        $leaseExtension = LeaseExtension ::findOrFail($this -> extensionId);
        $leaseExtension -> depreciation_conversion_rate = MonthEndConversionService ::monthEndDepreciationConversionRate($leaseExtension);
        $leaseExtension -> liability_conversion_rate = MonthEndConversionService ::monthEndLiabilityConversionRate($leaseExtension);
        $leaseExtension -> save();
    }

    /**
     * @param mixed $extensionId
     * @return LeaseEdited
     */
    public function setExtensionId($extensionId)
    {
        $this -> extensionId = $extensionId;
        return $this;
    }

    /**
     * @param $payDate
     * @param array $attr
     * @param $leasePaymentAmount
     * @param $leaseServiceAmount
     * @return array
     */
    private function fixedAmountValue($payDate, array $attr, $leasePaymentAmount, $leaseServiceAmount, $leaseExtension): array
    {
        $present = false;
        $paymentDateCarbon = Carbon ::parse($payDate) -> endOfMonth() -> toDateString();
        if(request() -> payment_month)
            $present = array_search($paymentDateCarbon, arrayDateToLastOfMonth(request() -> payment_month));
        if($present) {
            $attr['fixed_amount'] = request('payment_value')[$present];
            $attr['fees'] = request('payment_service_cost')[$present];
            $attr['added_amt'] = request('payment_service_cost')[$present];
        } else {
            $attr['fixed_amount'] = $leasePaymentAmount;
            $attr['fees'] = $leaseServiceAmount;
        }
        return $attr;
    }

    /**
     * @param array $attr
     * @param $leasePaymentAmount
     * @param $leaseServiceAmount
     * @return array
     */
    private function checkPaymentType($leaseFlows): array
    {
        $leaseFlows[count($leaseFlows) - 1];
        if($this -> lease -> leaseType -> payment_type == 'Advance' && !isset($leaseFlows[count($leaseFlows) - 1]['added_amt']) && $this -> lease -> lease_flow_per_year != 12) {
            $leaseFlows[count($leaseFlows) - 1]['fixed_amount'] = 0;
            $leaseFlows[count($leaseFlows) - 1]['fees'] = 0;
        }
        return $leaseFlows;

    }

}