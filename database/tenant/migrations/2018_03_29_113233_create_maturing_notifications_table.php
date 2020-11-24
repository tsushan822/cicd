<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaturingNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maturing_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('prior_days');
            $table->string('type');
            $table->string('table_name')->nullable();
            $table->string('column_name')->nullable();
            $table->boolean('active_status')->default(0);
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
        Schema::dropIfExists('maturing_notifications');
    }
}
