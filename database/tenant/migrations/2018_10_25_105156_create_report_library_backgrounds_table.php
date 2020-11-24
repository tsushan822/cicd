<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportLibraryBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('report_library_backgrounds', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('user_id');
            $table -> integer('attempts')->default(0);
            $table -> string('report_libraries');
            $table -> string('file_format');
            $table -> boolean('done') ->default(0);
            $table -> dateTime('start_time') ->nullable();
            $table -> dateTime('end_time') ->nullable();
            $table -> date('start_date') ->nullable();
            $table -> date('end_date') ->nullable();
            $table -> softDeletes();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('report_library_backgrounds');
    }
}
