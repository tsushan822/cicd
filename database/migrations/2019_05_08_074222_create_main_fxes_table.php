<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainFxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_fxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            //couldn't make currency base id due to index name length limitation
            $table->integer('ccy_base_id')->unsigned();
            $table->integer('ccy_cross_id')->unsigned();
            $table->string('rate_type');
            $table->string('source');
            $table->boolean('direct_quote')->default(1);
            $table->date('date');
            $table->decimal('rate_bid',16,8);
            $table->timestamps();
            //to avoid anyone adding double rates per day.
            $table->unique(array('ccy_base_id','ccy_cross_id','rate_type','date','source'));
            //$table->foreign('ccy_base_id','ccy_base_foreign')->references('id')->on('main_currencies');
            //$table->foreign('ccy_cross_id','ccy_cross_foreign')->references('id')->on('main_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_fxes');
    }
}
