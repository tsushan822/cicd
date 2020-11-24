<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateBackUpsTable extends \Hyn\Tenancy\Abstracts\AbstractMigration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('back_ups', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('customer_id') -> unsigned();
            $table -> boolean('always_backup') ->default(1) -> nullable();
            $table -> boolean('monthly_backup') ->default(1) -> nullable();
            $table -> integer('backup_days') ->default(7) -> nullable();
            $table -> foreign('customer_id') -> references('id') -> on('customers')->onDelete('cascade');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('back_ups');
    }
}
