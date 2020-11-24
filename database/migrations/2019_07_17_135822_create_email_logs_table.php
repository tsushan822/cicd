<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create('email_logs', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> integer('website_id') -> nullable();
            $table -> integer('user_id') -> nullable();
            $table -> text('message') -> nullable();
            $table -> text('header');
            $table -> text('subject');
            $table -> dateTime('sending_at');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('email_logs');
    }
}
