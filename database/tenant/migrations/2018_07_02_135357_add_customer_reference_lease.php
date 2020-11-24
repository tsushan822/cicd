<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerReferenceLease extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> text('customer_reference') -> nullable() -> after('portfolio_id');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> dropColumn('customer_reference');
        });
    }
}
