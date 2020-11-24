<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrezoneAlias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counterparties', function (Blueprint $table) {
            $table->string('trezone_alias')->nullable()->after('alias_fxall');
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
            $table->dropColumn('trezone_alias');
        });
    }
}
