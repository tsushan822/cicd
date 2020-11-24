<?php
namespace Seeds\Tenant;

use App\Zen\Setting\Model\BusinessDayConvention;
use Illuminate\Database\Seeder;

class BusinessDayConventionTableSeeder extends Seeder {

    public function run() {

        BusinessDayConvention::truncate();

        BusinessDayConvention::create([
            'convention' => 'No Adjustment',
            'definition' => 'Business Holidays are effectively ignored. Cash flows that fall on holidays are assumed to be distributed on the actual date.',
        ]);

        BusinessDayConvention::create([
            'convention' => 'Previous',
            'definition' => 'Cash flows that fall on a non-business day are assumed to be distributed on the previous business day.',
        ]);

        BusinessDayConvention::create([
            'convention' => 'Following',
            'definition' => 'Cash flows that fall on a non-business day are assumed to be distributed on the following business day.',
        ]);

        BusinessDayConvention::create([
            'convention' => 'Modified Previous',
            'definition' => 'Cash flows that fall on a non-business day are assumed to be distributed on the previous 
            business day. However if the previous business day is in a different month, the following business day is adopted instead.',
        ]);

        BusinessDayConvention::create([
            'convention' => 'Modified Following',
            'definition' => 'Cash flows that fall on a non-business day are assumed to be distributed on the following 
            business day. However if the following business day is in a different month, the previous business day is adopted instead.',
        ]);

        BusinessDayConvention::create([
            'convention' => 'End of Month - No Adjustment',
            'definition' => 'All cash flows are assumed to be distributed on the final day of the month (even if it is a non-business day).',
        ]);

        BusinessDayConvention::create([
            'convention' => 'End of Month - Previous',
            'definition' => 'All cash flows are assumed to be distributed on the final day of the month. If the final 
            day of the month is a non-business day, the previous business day is adopted.',
        ]);

        BusinessDayConvention::create([
            'convention' => 'End of Month - Following',
            'definition' => 'All cash flows are assumed to be distributed on the final day of the month. If the final 
            day of the month is a non-business day, the following business day is adopted.',
        ]);
    }

}
