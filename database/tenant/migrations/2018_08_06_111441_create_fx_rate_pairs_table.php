<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFxRatePairsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('fx_rate_pairs', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('base_currency');
            $table -> integer('converting_currency');
            $table -> integer('referencing_currency');
            $table -> softDeletes();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('fx_rate_pairs');
    }
}
