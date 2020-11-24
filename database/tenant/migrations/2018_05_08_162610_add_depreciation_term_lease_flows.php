<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepreciationTermLeaseFlows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lease_flows', function (Blueprint $table) {
            $table -> integer('depreciation_opening_balance') -> nullable() ->default(0) -> after('lease_id');
            $table -> integer('depreciation') -> nullable() ->default(0) -> after('depreciation_opening_balance');
            $table -> integer('depreciation_closing_balance') -> nullable() ->default(0) -> after('depreciation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lease_flows', function (Blueprint $table) {

        });
    }
}
