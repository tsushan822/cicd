<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('report_libraries', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('module_id');
            $table -> integer('user_id');
            $table -> text('criteria');
            $table -> string('route');
            $table -> string('report_name') -> nullable();
            $table -> string('custom_report_name') -> nullable();
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
        Schema ::dropIfExists('report_libraries');
    }
}
