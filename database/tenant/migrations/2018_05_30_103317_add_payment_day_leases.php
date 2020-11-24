<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentDayLeases extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> integer('payment_day') -> after('maturity_date') ->default(30) -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> dropColumn('payment_day');
        });
    }
}
