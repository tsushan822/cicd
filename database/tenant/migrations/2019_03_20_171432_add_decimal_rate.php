<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDecimalRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lease_extensions', function (Blueprint $table) {
            $table->decimal('liability_conversion_rate',24,12)->change();
            $table->decimal('depreciation_conversion_rate',24,12)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lease_extensions', function (Blueprint $table) {
            $table->decimal('liability_conversion_rate',20,6)->change();
            $table->decimal('depreciation_conversion_rate',20,6)->change();
        });
    }
}
