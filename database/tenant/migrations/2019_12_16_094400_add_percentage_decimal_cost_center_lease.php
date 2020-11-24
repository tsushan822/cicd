<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPercentageDecimalCostCenterLease extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::table('cost_center_lease', function (Blueprint $table) {
            $table -> decimal('percentage', 6, 2) -> change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::table('cost_center_lease', function (Blueprint $table) {
            $table -> integer('percentage') -> change();
        });
    }
}
