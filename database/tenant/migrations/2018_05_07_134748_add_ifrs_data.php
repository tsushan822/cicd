<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIfrsData extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('counterparties', function (Blueprint $table) {
            $table -> boolean('ifrs_accounting') ->default(false) -> after('limit_extra');
            $table -> decimal('lease_rate') ->nullable()-> after('ifrs_accounting');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('counterparties', function (Blueprint $table) {
            $table -> dropColumn('ifrs_accounting');
            $table -> dropColumn('lease_rate');
        });
    }
}
