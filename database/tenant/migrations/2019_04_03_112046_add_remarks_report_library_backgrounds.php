<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksReportLibraryBackgrounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::table('report_library_backgrounds', function (Blueprint $table) {
            $table -> string('remarks') -> after('file_format') -> nullable();
        });

        Schema ::table('book_keeping_settings', function (Blueprint $table) {
            $table -> boolean('ias_17') -> after('balance_sheet_separator') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::table('report_library_backgrounds', function (Blueprint $table) {
            $table -> dropColumn('remarks');
        });

        Schema ::table('book_keeping_settings', function (Blueprint $table) {
            $table -> dropColumn('ias_17');
        });
    }
}
