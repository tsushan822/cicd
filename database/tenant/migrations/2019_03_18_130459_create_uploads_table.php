<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('uploads', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('user_id');
            $table -> string('file_name') -> unique();
            $table -> integer('attempts') -> nullable();
            $table -> string('model');
            $table -> dateTime('start_time') -> nullable();
            $table -> dateTime('end_time') -> nullable();
            $table -> integer('rows_imported') -> nullable();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('uploads');
    }
}
