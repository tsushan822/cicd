<?php

namespace App\Zen\Report\Service\CashFlowManagement\Trezone;


use App\Zen\MmDeal\Service\DealFlowService;
use App\Zen\Report\Service\CashFlowManagement\AllCashFlow;

class TrezoneIntegrate extends AllCashFlow
{

    protected $returnValues = array();

    public function getAllFlows()
    {
        $modulesAvailable = request() -> get('module_id');

        if(is_array($modulesAvailable)) {
            if(in_array(config('cashflow.trezone.modules.Loan'), $modulesAvailable)) {
                $cashFlows = $this -> getLoanFlows();
                $this -> updateForLoan($cashFlows);
            }


            if(in_array(config('cashflow.trezone.modules.Guarantee'), $modulesAvailable)) {
                $guaranteeFlows = $this -> getGuaranteeFlows();
                $this -> updateForGuarantee($guaranteeFlows);
            }

            if(in_array(config('cashflow.trezone.modules.Lease'), $modulesAvailable)) {
                $leaseFlows = $this -> getLeaseFlows();
                $this -> updateForLease($leaseFlows);
            }

            if(in_array(config('cashflow.trezone.modules.Foreign Exchange'), $modulesAvailable)) {
                $fxDeals = $this -> getFxFlows();
                $this -> updateForFx($fxDeals);
            }
        }


        return $this -> returnValues;

    }

    public function setRequiredParameterForTrezone($allFlows)
    {

    }

    public function updateForLoan($cashFlows)
    {
        foreach($cashFlows as $cashFlow) {
            $value = [];
            $value['unit_code'] = $cashFlow -> mmDeal -> entity -> entity_code;
            $value['counterparty_code'] = $cashFlow -> mmDeal -> counterparty -> counterparty_code;
            $value['counterparty_name'] = $cashFlow -> mmDeal -> counterparty -> short_name;
            $value['date'] = $cashFlow -> payment_date;
            $value['amount'] = $cashFlow -> mmDeal -> no_capital_flow ? (0 + $cashFlow -> fees + DealFlowService ::getNetInterestAmount($cashFlow)) : (DealFlowService ::getNetInterestAmount($cashFlow) + $cashFlow -> fees + $cashFlow -> amortization_amount);
            $value['currency'] = $cashFlow -> mmDeal -> currency -> iso_4217_code;
            $value['description'] = $cashFlow -> text;
            $value['reference_code'] = 'Loan ' . $cashFlow -> mm_deal_id;
            $value['portfolio'] = $cashFlow -> mmDeal -> portfolio -> name;
            $value['account'] = $cashFlow -> entityAccount -> client_account_number;
            $value['counter_account'] = optional($cashFlow -> counterpartyAccount) -> client_account_number;
            $this -> returnValues[] = $value;
        }

    }

    public function updateForLease($leaseFlows)
    {
        foreach($leaseFlows as $leaseFlow) {
            $value = [];
            $value['unit_code'] = $leaseFlow -> lease -> entity -> entity_code;
            $value['counterparty_code'] = $leaseFlow -> lease -> counterparty -> counterparty_code;
            $value['counterparty_name'] = $leaseFlow -> lease -> counterparty -> short_name;
            $value['date'] = $leaseFlow -> payment_date;
            $value['amount'] = (-1) * $leaseFlow -> total_payment;
            $value['currency'] = $leaseFlow -> lease -> currency -> iso_4217_code;
            $value['description'] = $leaseFlow -> description;
            $value['reference_code'] = 'Lease ' . $leaseFlow -> lease_id;
            $value['portfolio'] = $leaseFlow -> lease -> portfolio -> name;
            $value['account'] = $leaseFlow -> lease -> account -> client_account_number;
            $value['counter_account'] = null;
            $this -> returnValues[] = $value;
        }
    }

    public function updateForGuarantee($guaranteeFlows)
    {
        foreach($guaranteeFlows as $guaranteeFlow) {
            $value = [];
            $value['unit_code'] = $guaranteeFlow -> guarantee -> applicant -> entity_code;
            $value['counterparty_code'] = $guaranteeFlow -> guarantee -> guarantor -> counterparty_code;
            $value['counterparty_name'] = $guaranteeFlow -> guarantee -> guarantor -> short_name;
            $value['date'] = $guaranteeFlow -> payment_date;
            $value['amount'] = -1 * ($guaranteeFlow -> guarantee_payment + $guaranteeFlow -> fees);
            $value['currency'] = $guaranteeFlow -> guarantee -> currency -> iso_4217_code;
            $value['description'] = $guaranteeFlow -> text;
            $value['reference_code'] = 'Guarantee ' . $guaranteeFlow -> guarantee_id;
            $value['portfolio'] = $guaranteeFlow -> guarantee -> portfolio -> name;
            $value['account'] = $guaranteeFlow -> guarantee -> account -> client_account_number;
            $value['counter_account'] = null;
            $this -> returnValues[] = $value;
        }
    }

    public function updateForFx($fxDeals)
    {
        foreach($fxDeals as $fx) {
            $value = [];
            $value['unit_code'] = $fx -> entity -> entity_code;
            $value['counterparty_code'] = $fx -> counterparty -> counterparty_code;
            $value['counterparty_name'] = $fx -> counterparty -> short_name;
            $value['date'] = $fx -> maturity_date;
            $value['amount'] = $fx -> notional_currency_amount;
            $value['currency'] = $fx -> notionalCurrency -> iso_4217_code;
            $value['description'] = $fx -> text;
            $value['reference_code'] = 'FxDeal ' . $fx -> id;
            $value['portfolio'] = $fx -> portfolio -> name;
            $value['account'] = $fx -> notionalAccount -> client_account_number;
            $value['counter_account'] = null;
            $this -> returnValues[] = $value;

            $value = [];
            $value['unit_code'] = $fx -> entity -> entity_code;
            $value['counterparty_code'] = $fx -> counterparty -> counterparty_code;
            $value['counterparty_name'] = $fx -> counterparty -> short_name;
            $value['date'] = $fx -> maturity_date;
            $value['amount'] = $fx -> cross_currency_amount;
            $value['currency'] = $fx -> crossCurrency -> iso_4217_code;
            $value['description'] = $fx -> text;
            $value['reference_code'] = 'FxDeal ' . $fx -> id;
            $value['portfolio'] = $fx -> portfolio -> name;
            $value['account'] = $fx -> crossAccount -> client_account_number;
            $value['counter_account'] = null;
            $this -> returnValues[] = $value;
        }
    }

}