<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConversionRatesLeaseExtensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lease_extensions', function (Blueprint $table) {
            $table -> decimal('liability_conversion_rate', 20, 6) -> after('lease_extension_rate') -> nullable();
            $table -> decimal('depreciation_conversion_rate', 20, 6) -> after('liability_conversion_rate') -> nullable();
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
            $table -> dropColumn('liability_conversion_rate');
            $table -> dropColumn('depreciation_conversion_rate');
        });
    }
}
