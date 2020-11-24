<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('counterparty_id');
            $table->text('account_name');
            $table->integer('client_account_number')->unique()->nullable();
            $table->text('client_account_name')->nullable();
            $table->boolean('balance_sheet')->default(1);
            $table->text('IBAN')->nullable();
            $table->text('BIC')->nullable();
            $table->text('bank')->nullable();
            $table->integer('currency_id')->unsigned();
            $table->integer('country_id')->unsigned()->nullable();
            //$table->text('alternative_account')->nullable();
            //$table->text('town')->nullable();
            $table->boolean('show_liq_view')->default(1);
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
