<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLiabilityComponentsLeaseExtensions extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> decimal('extension_exercise_price', 20, 6) -> nullable() -> after('depreciation_conversion_rate');
            $table -> decimal('extension_residual_value_guarantee', 20, 6) -> nullable() -> after('extension_exercise_price');
            $table -> decimal('extension_penalties_for_terminating', 20, 6) -> nullable() -> after('extension_residual_value_guarantee');

        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> dropColumn('extension_exercise_price');
            $table -> dropColumn('extension_residual_value_guarantee');
            $table -> dropColumn('extension_penalties_for_terminating');
        });
    }
}
