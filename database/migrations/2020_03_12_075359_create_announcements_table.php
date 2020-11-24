<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('announcements', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('user_id') -> nullable();
            $table -> boolean('for_owner') -> nullable() ->default(0);
            $table -> text('body')-> nullable();
            $table -> string('action_text') -> nullable();
            $table -> text('action_url') -> nullable();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::drop('announcements');
    }
}
