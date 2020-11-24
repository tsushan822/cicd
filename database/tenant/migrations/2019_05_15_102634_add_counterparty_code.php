<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCounterpartyCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counterparties', function (Blueprint $table) {
            $table->string('counterparty_code')->nullable()->after('lease_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counterparties', function (Blueprint $table) {
            $table->dropColumn('counterparty_code');
        });
    }
}
