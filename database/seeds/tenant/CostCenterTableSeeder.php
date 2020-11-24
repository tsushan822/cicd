<?php
namespace Seeds\Tenant;

use App\Zen\Setting\Model\CostCenter;
use Illuminate\Database\Seeder;

class CostCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attr = [
            'short_name' => 'Cost center 1',
            'long_name' =>'Cost center 1',
        ];
        Costcenter::create($attr);
    }
}
