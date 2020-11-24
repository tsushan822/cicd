<?php

namespace Tests\Browser;

use App\Zen\Lease\Model\LeaseType;
use App\Zen\User\Model\User;
use Tests\DuskTestCase;

class CreateLeaseTypeTest extends DuskTestCase
{
    protected $user;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_create_lease_type(): void
    {
        $this -> set_user();
        $type = now() -> format('m-d H-i') . 'Office simple another';

        $this -> create_lease_type($type);

        $firstCreated = LeaseType ::orderBy('id', 'desc') -> first();

        $this -> edit_lease_type($firstCreated, $type);

        $this -> delete_lease_type($firstCreated);
    }


    public function create_lease_type($type)
    {

        $this -> browse(function ($first) use ($type) {
            $first -> loginAs($this -> user) -> visit('/lease-types/create')
                -> type('type', $type)
                -> type('description', 'Office simple')
                -> select('interest_calculation_method', 'Simple')
                -> select('lease_type_item', 'Office')
                -> select('extra_payment_in_fees', 0)
                -> select('payment_type', 'In arrears ')
                -> select('business_day_convention_id', 6)
                -> select('exclude_first_payment', 1)
                -> press('#register_submit')
                -> pause(100)
                -> assertSee('Success!');
        });
    }

    public function edit_lease_type($firstCreated, $type)
    {
        $this -> browse(function ($first) use ($firstCreated, $type) {
            $first -> loginAs($this -> user) -> visit('/lease-types/' . ($firstCreated -> id) . '/edit')
                -> assertSee('Lease type ' . $firstCreated -> id)
                -> type('type', $type)
                -> type('description', 'Test Lease Description')
                -> type('lease_valuation_rate', '0.5')
                -> select('interest_calculation_method', 'Compound')
                -> select('lease_type_item', 'IT')
                -> select('extra_payment_in_fees', 0)
                -> select('payment_type', 'Advance')
                -> select('business_day_convention_id', 6)
                -> select('exclude_first_payment', 0)
                -> press('#register_submit')
                -> assertSee('Success!');
        });
    }

    public function delete_lease_type($firstCreated)
    {
        $this -> browse(function ($first) use ($firstCreated) {
            $first -> loginAs($this -> user) -> visit('/lease-types/' . ($firstCreated -> id))
                -> assertSee('Delete ' . $firstCreated -> id)
                -> press('#register_submit')
                -> pause(100)
                -> assertSee('Lease type deleted!');
        });
    }

    public function set_user()
    {
        $this -> user = User ::find(1);
    }

    public function test_compound_interest()
    {
        $this -> set_user();
        $type = now() -> format('m-d H-i') . 'Office simple another';
        $this -> create_lease_type($type);
        $firstCreated = LeaseType ::orderBy('id', 'desc') -> first();

        $lease = $this->create_lease(100000,$firstCreated,'2018-01-01','2023-12-31',8,'2019-01-31',1);
        $this->match_with_database($lease, 6);

        $this -> delete_lease_type($firstCreated);
    }
}
