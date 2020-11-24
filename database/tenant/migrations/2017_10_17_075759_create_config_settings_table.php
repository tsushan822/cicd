<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('type');
            $table->text('description')->nullable();
            $table->boolean('active')->nullable();
            $table->integer('value_int')->nullable();
            $table->date('value_date')->nullable();
            $table->text('value_text')->nullable();
            $table->decimal('value_amount')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('config_settings');
    }
}
