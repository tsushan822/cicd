<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserIdTypeUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maturing_notifications', function (Blueprint $table) {
            $table->unique(['user_id','type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maturing_notifications', function (Blueprint $table) {
            $table->dropUnique('maturing_notifications_user_id_type');
        });
    }
}
