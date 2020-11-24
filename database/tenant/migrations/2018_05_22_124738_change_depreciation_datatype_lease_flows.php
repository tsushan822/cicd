<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDepreciationDatatypeLeaseFlows extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_flows', function (Blueprint $table) {
            $table -> decimal('depreciation_opening_balance', 20, 6) -> change();
            $table -> decimal('depreciation', 20, 6) -> change();
            $table -> decimal('depreciation_closing_balance', 20, 6) -> change();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_flows', function (Blueprint $table) {
            //
        });
    }
}
