<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create('import_files', function (Blueprint $table) {
            $table -> id();
            $table -> string('file_name');
            $table -> dateTime('start_time');
            $table -> dateTime('end_time') -> nullable();
            $table -> integer('user_id') -> nullable();
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
        Schema ::dropIfExists('import_files');
    }
}
