<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create('failed_login_attempts', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedInteger('user_id') -> nullable();
            $table -> string('email_address');
            $table -> ipAddress('ip_address');
            $table -> timestamps();
        });

        Schema ::table('admin_settings', function (Blueprint $table) {
            $table -> integer('min_password_length') -> after('user_id') ->default(8) -> nullable();
            $table -> integer('max_password_length') -> after('min_password_length') ->default(16) -> nullable();
            $table -> string('password_criteria') -> after('max_password_length') -> nullable();
            $table -> integer('number_of_unsuccessful_login') -> after('password_criteria') ->default(5) -> nullable();
            $table -> boolean('enable_failed_login_lock') -> after('number_of_unsuccessful_login') ->default(false) -> nullable();
            $table -> integer('password_change_days') -> after('enable_failed_login_lock') ->default(365) -> nullable();
            $table -> integer('enable_change_password') -> after('password_change_days') ->default(false) -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('failed_login_attempts');

        Schema ::table('admin_settings', function (Blueprint $table) {
            $table -> dropColumn(['min_password_length', 'max_password_length', 'password_criteria', 'number_of_unsuccessful_login', 'password_change_days', 'enable_change_password', 'enable_failed_login_lock']);
        });

    }
}
