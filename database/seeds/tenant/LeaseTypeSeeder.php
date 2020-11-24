<?php

namespace Seeds\Tenant;

use App\Zen\Lease\Model\LeaseType;
use Illuminate\Database\Seeder;

class LeaseTypeSeeder extends Seeder
{

    public function run()
    {

        LeaseType ::truncate();

        //1
        $result = LeaseType ::create([
            'type' => 'Office advance',
            'description' => 'Office rent paid in advance',
            'lease_type_item' => 'Building',
            'payment_type' => 'Advance',
            'exclude_first_payment' => 1,

        ]);

        //2
        $result = LeaseType ::create([
            'type' => 'Office in arrears',
            'description' => 'Office rent paid in arrears',
            'lease_type_item' => 'Building',
            'payment_type' => 'In arrears',
            'exclude_first_payment' => 0,

        ]);

        //2
        $result = LeaseType ::create([
            'type' => 'Car in arrears',
            'description' => 'Car lease paid in arrears',
            'lease_type_item' => 'Vehicle',
            'payment_type' => 'In arrears',
            'exclude_first_payment' => 0,
        ]);

    }

}
