<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecuteCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create('execute_commands', function (Blueprint $table) {
            $table -> id();
            $table -> integer('customer_id') -> nullable();
            $table -> string('command_type');
            $table -> date('date_to_run');
            $table -> dateTime('started_at') -> nullable();
            $table -> dateTime('ended_at') -> nullable();
            $table -> boolean('done') ->default(0);
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
        Schema ::dropIfExists('execute_commands');
    }
}
