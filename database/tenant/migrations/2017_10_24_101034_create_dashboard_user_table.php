<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dashboard_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('active_status')->unsigned();
            $table->timestamps();
            $table->foreign('dashboard_id')->references('id')->on('dashboards')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard_user');
    }
}
