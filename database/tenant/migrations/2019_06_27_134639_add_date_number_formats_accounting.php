<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateNumberFormatsAccounting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::table('book_keeping_settings', function (Blueprint $table) {
            $table -> string('date_format') ->default('Y-m-d') -> after('ias_17');
            $table -> string('thousand_separator') ->default(',') -> after('date_format');
            $table -> string('decimal_separator') ->default('.') -> after('thousand_separator');
            $table -> integer('decimal_place') ->default(2) -> after('decimal_separator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::table('book_keeping_settings', function (Blueprint $table) {
            $table -> dropColumn(['date_format', 'thousand_separator', 'decimal_separator', 'decimal_place']);
        });
    }
}
