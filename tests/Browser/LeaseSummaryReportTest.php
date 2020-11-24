<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Zen\User\Model\User;

class LeaseSummaryReportTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @return void
     */
    public function testLeaseSummary()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $firstCreated = $this -> create_lease( '100,000.00', 1, '2018-01-01', '2019-01-31', 8, '2018-01-31');

            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2019-02-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#portfolio_id',1)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '4,096.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '4,096.00')
                -> assertSeeIn('#depreciation', '3,643.50')
                -> assertSeeIn('#interest_cost', '264.01')
                -> assertSeeIn('#accrued_interest', '0.00')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '-201.08')
                //-> assertSeeIn('#unrealised_fx_diff', '-2612.5')
                -> assertSeeIn('#additions_to_liability', '0.00')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '0.00')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '3,831.99')
                -> assertSeeIn('#right_of_use_asset', '38,830.68')
                -> assertSeeIn('#short_term_liability', '31,649.05')
                -> assertSeeIn('#long_term_liability', '11,166.32')
                -> assertSeeIn('#total_liability', '42,815.37');

            $this -> delete_lease($firstCreated);
        });
    }


    /**
     * A Dusk test example.
     * @return void
     */
    public function test_lease_summary_1()
    {
        $firstCreated = $this -> create_lease('100,000.00', 1, '2018-01-01', '2023-12-31', 8, '2019-01-31', 1);

        $this -> browse(function ($first) use($firstCreated){
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2020-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id',$firstCreated)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '100,000.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '100,000.00')
                -> assertSeeIn('#depreciation', '6,934.32')
                -> assertSeeIn('#interest_cost', '26,497.01')
                -> assertSeeIn('#accrued_interest', '1,746.23')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '0.00')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '0.00')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '73,502.99')
                -> assertSeeIn('#right_of_use_asset', '325,913.02')
                -> assertSeeIn('#short_term_liability', '79,383.22')
                -> assertSeeIn('#long_term_liability', '178,326.47')
                -> assertSeeIn('#total_liability', '257,709.70');
        });
        $this -> delete_lease($firstCreated);
    }

    /**
     * A Dusk test example.
     * @return void
     */
    public function test_lease_summary_2()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2020-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id',2)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '44,100.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '44,100.00')
                -> assertSeeIn('#depreciation', '12,375.96')
                -> assertSeeIn('#interest_cost', '6,616.21')
                -> assertSeeIn('#accrued_interest', '1,998.49')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '0.00')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '0.00')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '37,483.79')
                -> assertSeeIn('#right_of_use_asset', '284,647.14')
                -> assertSeeIn('#short_term_liability', '159,788.37')
                -> assertSeeIn('#long_term_liability', '133,538.21')
                -> assertSeeIn('#total_liability', '293,326.58');
        });
    }

    /**
     * A Dusk test example.
     * @return void
     */
    public function test_lease_summary_3()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2019-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id', 3)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '2,000.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '2,000.00')
                -> assertSeeIn('#depreciation', '1,580.31')
                -> assertSeeIn('#interest_cost', '776.82')
                -> assertSeeIn('#accrued_interest', '1,998.49')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '118,523.55')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '118,523.55')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '1,223.18')
                -> assertSeeIn('#right_of_use_asset', '116,943.24')
                -> assertSeeIn('#short_term_liability', '15,329.98')
                -> assertSeeIn('#long_term_liability', '101,970.40')
                -> assertSeeIn('#total_liability', '117,300.38');

            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2020-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id', 3)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '2,200.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '2,200.00')
                -> assertSeeIn('#depreciation', '1,465.19')
                -> assertSeeIn('#interest_cost', '742.83')
                -> assertSeeIn('#accrued_interest', '0.00')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '10,329.51')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '10,329.51')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '1,457.17')
                -> assertSeeIn('#right_of_use_asset', '108,424.10')
                -> assertSeeIn('#short_term_liability', '18,262.59')
                -> assertSeeIn('#long_term_liability', '93,904.84')
                -> assertSeeIn('#total_liability', '112,167.44');
        });
    }

    /**
     * A Dusk test example.
     * @return void
     */
    public function test_lease_summary_4()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2019-03-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id', 4)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '25,000.000')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '25,000.00')
                -> assertSeeIn('#depreciation', '7,071.72')
                -> assertSeeIn('#interest_cost', '6,788.85')
                -> assertSeeIn('#accrued_interest', '0.00')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '0.00')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '0.00')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '18,211.15')
                -> assertSeeIn('#right_of_use_asset', '318,227.56')
                -> assertSeeIn('#short_term_liability', '76,560.39')
                -> assertSeeIn('#long_term_liability', '244,671.20')
                -> assertSeeIn('#total_liability', '321,231.59');

            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2020-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id', 3)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '15,000.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '15,000.00')
                -> assertSeeIn('#depreciation', '2,677.76')
                -> assertSeeIn('#interest_cost', '2,694.78')
                -> assertSeeIn('#accrued_interest', '0.00')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '0.00')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '0.00')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '12,305.22')
                -> assertSeeIn('#right_of_use_asset', '120,499.05')
                -> assertSeeIn('#short_term_liability', '51,731.66')
                -> assertSeeIn('#long_term_liability', '70,701.89')
                -> assertSeeIn('#total_liability', '122,433.55');
        });
    }

    /**
     * A Dusk test example.
     * @return void
     */
    public function test_lease_summary_5()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2019-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id', 5)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '4,000.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '4,000.00')
                -> assertSeeIn('#depreciation', '3,247.44')
                -> assertSeeIn('#interest_cost', '1,385.58')
                -> assertSeeIn('#accrued_interest', '0.00')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '207,836.47')
                -> assertSeeIn('#decrease_to_liability', '0.00')
                -> assertSeeIn('#additions_to_roa', '207,836.47')
                -> assertSeeIn('#decrease_to_roa', '0.00')
                -> assertSeeIn('#repayment_of_loan', '2,614.42')
                -> assertSeeIn('#right_of_use_asset', '204,589.03')
                -> assertSeeIn('#short_term_liability', '32,766.38')
                -> assertSeeIn('#long_term_liability', '172,455.67')
                -> assertSeeIn('#total_liability', '205,222.05');

            $first -> loginAs($user) -> visit('/reporting/lease-summary')
                -> keys('#end_date', '2020-01-01')
                -> select('#number_of_month', 1)
                -> select('#currency_id', 2)
                -> select('#lease_id', 5)
                -> press('submit')
                -> waitFor('#datatable-summary-lease_wrapper', 5)
                -> assertSeeIn('#fixed_amount', '0.00')
                -> assertSeeIn('#service_cost', '0.00')
                -> assertSeeIn('#total_lease_cost', '0.00')
                -> assertSeeIn('#depreciation', '2,453.52')
                -> assertSeeIn('#interest_cost', '1,089.64')
                -> assertSeeIn('#accrued_interest', '0.00')
                -> assertSeeIn('#realised_diff_from_change', '0.00')
                -> assertSeeIn('#realised_fx_diff', '0.00')
                -> assertSeeIn('#unrealised_fx_diff', '0.00')
                -> assertSeeIn('#additions_to_liability', '0.00')
                -> assertSeeIn('#decrease_to_liability', '-11,841.76')
                -> assertSeeIn('#additions_to_roa', '0.00')
                -> assertSeeIn('#decrease_to_roa', '-11,841.76')
                -> assertSeeIn('#repayment_of_loan', '-1,089.64')
                -> assertSeeIn('#right_of_use_asset', '154,571.85')
                -> assertSeeIn('#short_term_liability', '27,565.26')
                -> assertSeeIn('#long_term_liability', '136,969.70')
                -> assertSeeIn('#total_liability', '164,534.97');
        });
    }
}
