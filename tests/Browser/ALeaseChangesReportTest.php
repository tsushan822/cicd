<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Zen\User\Model\User;

class ALeaseChangesReportTest extends DuskTestCase
{

    public function test_see_all_reports_page()
    {
        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reports-all')
                -> assertSee('Lease Changes Report');
        });
    }
    /**
     * A Dusk test example.
     * @return void
     */
    public function testGtPage1To6()
    {

        $this -> browse(function ($first) {
            //First lease change report //id 301 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2016-01-01', '2017-12-31', 8, '2016-01-31');
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> keys('#start_date', '2015-12-31')
                -> keys('#end_date', '2016-07-31')
                -> pause(2000)
                -> type('#lease_id', $firstCreated)
                -> assertSeeIn('.cur1', 'USD')
                -> assertSeeIn('.liability_opening_balance1', '11,086.46')
                -> assertSeeIn('.liability_opening_balance_addition1', '11,086.46')
                -> assertSeeIn('.liability_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance1', '11,086.46')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '11,086.46')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '0.00')
                -> assertSeeIn('.realised_fx_difference1', '0.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });

        $this -> browse(function ($first) {
            //Second lease change report //id 38 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-12-31', 8, '2018-01-31');
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2018-09-01')
                -> keys('#end_date', '2018-09-30')
                -> press('submit')
                -> assertSeeIn('.cur1', 'EUR')
                -> assertSeeIn('.liability_opening_balance1', '10,662.45')
                -> assertDontSeeIn('.liability_opening_balance1', '-10,662.45')
                -> assertSeeIn('.liability_opening_balance_addition1', '10,662.45')
                -> assertDontSeeIn('.liability_opening_balance_addition1', '-10,662.45')
                -> assertSeeIn('.liability_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance1', '10,662.45')
                -> assertDontSeeIn('.depreciation_opening_balance1', '-10,662.45')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '10,662.45')
                -> assertDontSeeIn('.depreciation_opening_balance_addition1', '-10,662.45')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '0.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');

        });

        $this -> browse(function ($first) {
            //Second lease change report //id 301 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-12-31', 8, '2018-01-31');
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2018-09-01')
                -> keys('#end_date', '2018-09-30')
                -> press('submit')
                -> assertSeeIn('.cur1', 'EUR')
                -> assertSeeIn('.liability_opening_balance1', '10,662.45')
                -> assertDontSeeIn('.liability_opening_balance1', '-10,662.45')
                -> assertSeeIn('.liability_opening_balance_addition1', '10,662.45')
                -> assertDontSeeIn('.liability_opening_balance_addition1', '-10,662.45')
                -> assertSeeIn('.liability_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance1', '10,662.45')
                -> assertDontSeeIn('.depreciation_opening_balance1', '-10,662.45')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '10,662.45')
                -> assertDontSeeIn('.depreciation_opening_balance_addition1', '-10,662.45')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '0.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');

        });

        $this -> browse(function ($first) {
            //Third lease change report //id 23 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-12-31', 8, '2018-01-31');
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2018-09-01')
                -> keys('#end_date', '2018-09-30')
                -> press('submit')
                -> assertSeeIn('.cur1', 'EUR')
                -> assertSeeIn('.liability_opening_balance1', '-5,100.30')
                -> assertSeeIn('.liability_opening_balance_addition1', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease1', '-5,100.30')
                -> assertSeeIn('.depreciation_opening_balance1', '-4,644.02')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '-4,644.02')
                -> assertSeeIn('.realised_difference1', '456.28')
                -> assertDontSeeIn('.realised_difference1', '-456.28')
                -> assertSeeIn('.realised_difference_base_currency1', '456.28')
                -> assertDontSeeIn('.realised_difference_base_currency1', '-456.28')
                -> assertSeeIn('.cur2', 'EUR')
                -> assertSeeIn('.liability_opening_balance2', '529.49')
                -> assertDontSeeIn('.liability_opening_balance2', '-529.49')
                -> assertSeeIn('.liability_opening_balance_addition2', '529.49')
                -> assertDontSeeIn('.liability_opening_balance_addition2', '-529.49')
                -> assertSeeIn('.liability_opening_balance_decrease2', '0.00')
                -> assertSeeIn('.depreciation_opening_balance2', '529.49')
                -> assertDontSeeIn('.depreciation_opening_balance2', '-529.49')
                -> assertSeeIn('.depreciation_opening_balance_addition2', '529.49')
                -> assertDontSeeIn('.depreciation_opening_balance_addition2', '-529.49')
                -> assertSeeIn('.depreciation_opening_balance_decrease2', '0.00')
                -> assertSeeIn('.realised_difference2', '0.00')
                -> assertSeeIn('.realised_difference_base_currency2', '0.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');
        });


        $this -> browse(function ($first) {
            //Fourth lease change report //id 40 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-12-31', 8, '2018-01-31', 4);
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2018-10-01')
                -> keys('#end_date', '2018-10-31')
                -> press('submit')
                -> assertSeeIn('.cur1', 'EUR')
                -> assertSeeIn('.liability_opening_balance1', '1,416.39')
                -> assertDontSeeIn('.liability_opening_balance1', '-1,416.39')
                -> assertSeeIn('.liability_opening_balance_addition1', '1,416.39')
                -> assertDontSeeIn('.liability_opening_balance_addition1', '-1,416.39')
                -> assertSeeIn('.liability_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance1', '1,416.39')
                -> assertDontSeeIn('.depreciation_opening_balance1', '-1,416.39')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '1,416.39')
                -> assertDontSeeIn('.depreciation_opening_balance_addition1', '-1,416.39')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '0.00')
                -> assertSeeIn('.cur2', 'EUR')
                -> assertSeeIn('.liability_opening_balance2', '-8,498.37')
                -> assertSeeIn('.liability_opening_balance_addition2', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease2', '-8,498.37')
                -> assertSeeIn('.depreciation_opening_balance2', '-8,261.57')
                -> assertSeeIn('.depreciation_opening_balance_addition2', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease2', '-8,261.57')
                -> assertSeeIn('.realised_difference2', '236.79')
                -> assertDontSeeIn('.realised_difference2', '-236.79')
                -> assertSeeIn('.realised_difference_base_currency2', '236.79')
                -> assertDontSeeIn('.realised_difference_base_currency2', '-236.79')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');

        });

        $this -> browse(function ($first) {
            //Fifth lease change report //id 18 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2018-12-31', 8, '2018-01-31');
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', '18')
                -> keys('#start_date', '2018-11-01')
                -> keys('#end_date', '2018-12-31')
                -> press('submit')
                -> assertSeeIn('.cur1', 'EUR')
                -> assertSeeIn('.liability_opening_balance1', '-12,432.86')
                -> assertSeeIn('.liability_opening_balance_addition1', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease1', '-12,432.86')
                -> assertSeeIn('.depreciation_opening_balance1', '-12,010.33')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '-12,010.33')
                -> assertSeeIn('.realised_difference1', '422.54')
                -> assertDontSeeIn('.realised_difference1', '-422.54')
                -> assertSeeIn('.realised_difference_base_currency1', '422.54')
                -> assertDontSeeIn('.realised_difference_base_currency1', '-422.54')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');

        });

        $this -> browse(function ($first) {
            //Sixth lease change report //id 193 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-07-31', 8, '2018-01-31' );
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2018-02-01')
                -> keys('#end_date', '2018-03-31')
                -> press('submit')
                -> waitFor('#datatable-change-lease_wrapper', 5)
                -> assertSeeIn('.cur1', 'EUR')
                -> assertSeeIn('.liability_opening_balance1', '-17,000.00')
                -> assertSeeIn('.liability_opening_balance_addition1', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease1', '-21,238.11')
                -> assertSeeIn('.depreciation_opening_balance1', '-17,000.00')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '-21,250.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '-11.89')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');

        });

        $this -> browse(function ($first) {
            //Seventh lease change report //id 37 from zentmsnew
            $firstCreated = $this -> create_lease(1000, 1, '2018-01-01', '2019-12-31', 8, '2018-01-31' );
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', $firstCreated)
                -> keys('#start_date', '2018-04-01')
                -> keys('#end_date', '2018-04-30')
                -> press('submit')
                -> assertSeeIn('.cur1', 'USD')
                -> assertSeeIn('.liability_opening_balance1', '3,916.86')
                -> assertDontSeeIn('.liability_opening_balance1', '-3,916.86')
                -> assertSeeIn('.liability_opening_balance_addition1', '3,166.42')
                -> assertDontSeeIn('.liability_opening_balance_addition1', '-3,166.42')
                -> assertSeeIn('.liability_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance1', '3,916.86')
                -> assertDontSeeIn('.depreciation_opening_balance1', '-3,916.86')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '3,166.42')
                -> assertDontSeeIn('.depreciation_opening_balance_addition1', '-3,166.42')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '0.00')
                -> visit('/leases/' . ($firstCreated))
                -> assertSee('Delete ' . $firstCreated)
                -> press('Delete');

        });


        /*

        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', '195')
                -> keys('#start_date', '2018-09-01')
                -> keys('#end_date', '2018-09-30')
                -> press('submit')
                -> waitFor('#datatable-change-lease_wrapper', 5)
                -> assertSeeIn('.cur1', 'USD')
                -> assertSeeIn('.liability_opening_balance1', '-21,220.84')
                -> assertSeeIn('.liability_opening_balance_addition1', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease1', '-18,139.02')
                -> assertSeeIn('.depreciation_opening_balance1', '-20,750.53')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '-16,626.93')
                -> assertSeeIn('.realised_difference1', '470.31')
                -> assertSeeIn('.realised_difference_base_currency1', '1,512.09')
                -> assertSeeIn('.realised_fx_difference1', '-1,246.40');
        });

        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', '196')
                -> keys('#start_date', '2018-09-01')
                -> keys('#end_date', '2019-03-31')
                -> press('submit')
                -> waitFor('#datatable-change-lease_wrapper', 5)
                -> assertSeeIn('.cur1', 'USD')
                -> assertSeeIn('.liability_opening_balance1', '1,515.77')
                -> assertSeeIn('.liability_opening_balance_addition1', '1,214.54')
                -> assertSeeIn('.liability_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance1', '1,515.77')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '1,214.55')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '0.00')
                -> assertSeeIn('.realised_difference1', '0.00')
                -> assertSeeIn('.realised_difference_base_currency1', '0.00')
                -> assertSeeIn('.realised_fx_difference1', '0.00')


                -> assertSeeIn('.cur2', 'USD')
                -> assertSeeIn('.liability_opening_balance2', '-10,610.42')
                -> assertSeeIn('.liability_opening_balance_addition2', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease2', '-9,124.96')
                -> assertSeeIn('.depreciation_opening_balance2', '-10,365.93')
                -> assertSeeIn('.depreciation_opening_balance_addition2', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease2', '-8,305.95')
                -> assertSeeIn('.realised_difference2', '244.49')
                -> assertSeeIn('.realised_difference_base_currency2', '819.01')
                -> assertSeeIn('.realised_fx_difference2', '-623.20');
        });

        $this -> browse(function ($first) {
            $user = User ::find(1);
            $first -> loginAs($user) -> visit('/reporting/change-lease')
                -> type('#lease_id', '197')
                -> keys('#start_date', '2018-09-01')
                -> keys('#end_date', '2019-03-31')
                -> press('submit')
                -> waitFor('#datatable-change-lease_wrapper', 5)
                -> assertSeeIn('.cur1', 'USD')
                -> assertSeeIn('.liability_opening_balance1', '-10,882.56')
                -> assertSeeIn('.liability_opening_balance_addition1', '0.00')
                -> assertSeeIn('.liability_opening_balance_decrease1', '-9,359.00')
                -> assertSeeIn('.depreciation_opening_balance1', '-10,429.79')
                -> assertSeeIn('.depreciation_opening_balance_addition1', '0.00')
                -> assertSeeIn('.depreciation_opening_balance_decrease1', '-8,357.12')
                -> assertSeeIn('.realised_difference1', '452.77')
                -> assertSeeIn('.realised_difference_base_currency1', '1,001.88')
                -> assertSeeIn('.realised_fx_difference1', '-639.19')


                -> assertSeeIn('.cur2', 'USD')
                -> assertSeeIn('.liability_opening_balance2', '544.27')
                -> assertSeeIn('.liability_opening_balance_addition2', '436.11')
                -> assertSeeIn('.liability_opening_balance_decrease2', '0.00')
                -> assertSeeIn('.depreciation_opening_balance2', '544.27')
                -> assertSeeIn('.depreciation_opening_balance_addition2', '436.11')
                -> assertSeeIn('.depreciation_opening_balance_decrease2', '0.00')
                -> assertSeeIn('.realised_difference2', '0.00')
                -> assertSeeIn('.realised_difference_base_currency2', '0.00')
                -> assertSeeIn('.realised_fx_difference2', '0.00');
        });

  */
    }

}
