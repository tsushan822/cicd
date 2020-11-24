<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFxRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create('fx_rates', function (Blueprint $table) {
            $table -> increments('id');
            //couldn't make currency base id due to index name length limitation
            $table -> integer('ccy_base_id') -> unsigned();
            $table -> integer('ccy_cross_id') -> unsigned();
            $table -> boolean('direct_quote') -> nullable();
            $table -> date('date');
            $table -> decimal('rate_bid', 16, 8);
            $table -> string('source', 100) ->default('System');
            $table -> integer('user_id') -> nullable();
            $table -> integer('updated_user_id') -> nullable();
            $table -> softDeletes();
            $table -> timestamps();
            //to avoid anyone adding double rates per day.
            $table -> unique(array('ccy_base_id', 'ccy_cross_id', 'date'));
            $table -> foreign('ccy_base_id') -> references('id') -> on('currencies');
            $table -> foreign('ccy_cross_id') -> references('id') -> on('currencies');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('fx_rates');
    }
}
