<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessDayConventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_day_conventions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('convention',['No Adjustment','Previous','Following','Modified Previous','Modified Following',
                'End of Month - No Adjustment','End of Month - Previous','End of Month - Following']);
            $table->text('definition');
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
        Schema::dropIfExists('business_day_conventions');
    }
}
