<?php
namespace Seeds\Tenant;

use App\Zen\Setting\Model\Dashboard;
use Illuminate\Database\Seeder;

class DashboardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Dashboard ::truncate();
        $dashboard = [
            ['item' => 'Guarantee Maturity Chart', 'name' => 'guarantee_maturity_chart', 'module_id' => 3],
            ['item' => 'Total Limit Usage', 'name' => 'total_limit_usage', 'module_id' => 3],
            ['item' => 'Limit Usage Per Guarantor', 'name' => 'limit_usage_per_gurantor', 'module_id' => 3],
            ['item' => 'Number of guarantees per type and guarantor', 'name' => 'gurantees_per_type_guarantor', 'module_id' => 3],
            ['item' => 'Liquidity View', 'name' => 'liquidity_view'],
            ['item' => 'Non Confirmed Foreign Exchange Deals', 'name' => 'non_confirmed_fxdeals', 'module_id' => 1],
            ['item' => 'Lock Deal Flow', 'name' => 'lock_deal_flow', 'module_id' => 2],
        ];
        foreach($dashboard as $item) {
            Dashboard ::create($item);
        }
    }
}
