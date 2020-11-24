<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsLeases extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> decimal('exercise_price', 20, 6) -> nullable() -> after('text');
            $table -> decimal('residual_value_guarantee', 20, 6) -> nullable() -> after('exercise_price');
            $table -> decimal('penalties_for_terminating', 20, 6) -> nullable() -> after('residual_value_guarantee');
            $table -> decimal('payment_before_commencement_date', 20, 6) -> nullable() -> after('penalties_for_terminating');
            $table -> decimal('initial_direct_cost', 20, 6) -> nullable() -> after('payment_before_commencement_date');
            $table -> decimal('cost_dismantling_restoring_asset', 20, 6) -> nullable() -> after('initial_direct_cost');
            $table -> decimal('lease_incentives_received', 20, 6) -> nullable() -> after('cost_dismantling_restoring_asset');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> dropColumn('exercise_price');
            $table -> dropColumn('residual_value_guarantee');
            $table -> dropColumn('penalties_for_terminating');
            $table -> dropColumn('payment_before_commencement_date');
            $table -> dropColumn('initial_direct_cost');
            $table -> dropColumn('cost_dismantling_restoring_asset');
            $table -> dropColumn('lease_incentives_received');
        });
    }
}
