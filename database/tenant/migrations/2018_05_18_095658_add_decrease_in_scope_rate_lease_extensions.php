<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDecreaseInScopeRateLeaseExtensions extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> decimal('decrease_in_scope_rate') -> nullable() -> after('lease_extension_rate');

        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> dropColumn('decrease_in_scope_rate');
        });
    }
}
