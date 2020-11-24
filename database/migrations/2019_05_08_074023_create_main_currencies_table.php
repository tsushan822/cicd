<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('iso_4217_code');
            $table->string('iso_3166_code');
            $table->integer('iso_number');
            $table->string('currency_name',50);
            $table->boolean('active_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_currencies');
    }
}
