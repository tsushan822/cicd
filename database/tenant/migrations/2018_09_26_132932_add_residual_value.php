<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResidualValue extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> decimal('residual_value', 20, 6) -> after('lease_incentives_received') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> dropColumn('residual_value');
        });
    }
}
