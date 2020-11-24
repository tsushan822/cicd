<?php

namespace Seeds\Tenant;

use App\Zen\Setting\Model\Portfolio;
use Illuminate\Database\Seeder;

class PortfoliosTableSeeder extends Seeder
{

    public function run()
    {
        Portfolio ::truncate();

        Portfolio ::create([
            'name' => 'Leasing',
            'long_name' => 'Leasing',
        ]);

    }
}
