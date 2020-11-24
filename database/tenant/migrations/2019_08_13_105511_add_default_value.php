<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::table('table_orders', function (Blueprint $table) {
            $table -> string('default_value') -> after('column_name') -> nullable();
            $table -> string('remarks') -> after('default_value') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::table('table_orders', function (Blueprint $table) {
            $table -> dropColumn(['default_value', 'remarks']);
        });
    }
}
