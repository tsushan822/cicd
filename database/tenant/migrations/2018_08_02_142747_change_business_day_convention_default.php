<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBusinessDayConventionDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lease_types', function (Blueprint $table) {
            $table->integer('business_day_convention_id')->default(1)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lease_types', function (Blueprint $table) {
            $table->dropColumn('business_day_convention_id');
        });
    }
}
