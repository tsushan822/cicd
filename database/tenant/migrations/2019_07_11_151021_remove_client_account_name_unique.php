<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveClientAccountNameUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropUnique('accounts_client_account_number_unique');
        });

        Schema::table('counterparties', function (Blueprint $table) {
            $table->renameColumn('trezone_alias','entity_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->unique('client_account_number');
        });

        Schema::table('counterparties', function (Blueprint $table) {
            $table->renameColumn('entity_code','trezone_alias');
        });
    }
}
