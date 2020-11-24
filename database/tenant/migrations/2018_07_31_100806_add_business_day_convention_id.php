<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessDayConventionId extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_types', function (Blueprint $table) {
            $table -> integer('business_day_convention_id') ->default(3) -> after('lease_type_item');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_types', function (Blueprint $table) {
            $table -> dropColumn('business_day_convention_id');
        });
    }
}
