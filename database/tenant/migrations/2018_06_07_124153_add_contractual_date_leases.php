<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractualDateLeases extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> date('contractual_end_date') -> after('maturity_date') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('leases', function (Blueprint $table) {
            $table -> dropColumn('contractual_end_date');
        });
    }
}
