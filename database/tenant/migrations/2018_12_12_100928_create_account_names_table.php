<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountNamesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('account_names', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('counterparty_id') -> nullable();
            $table -> integer('portfolio_id') -> nullable();
            $table -> integer('instrument_id') -> nullable();
            $table -> integer('module_id') -> nullable();
            $table -> boolean('is_positive') ->default(1) -> nullable();
            $table -> string('account_type') ->default('Realised');
            $table -> string('debit_account_id') ->default(1) -> nullable();
            $table -> boolean('debit_bank_account') ->default(0) -> nullable();
            $table -> boolean('credit_bank_account') ->default(0) -> nullable();
            $table -> string('credit_account_id') ->default(1) -> nullable();
            $table -> boolean('is_internal') ->default(1) -> nullable();
            $table -> boolean('display_on') ->default(1) -> nullable();
            $table -> boolean('default_for_all_counterparties') ->default(1) -> nullable();
            $table -> string('item');
            $table -> integer('user_id')->nullable();
            $table -> integer('updated_user_id')->nullable();
            $table -> softDeletes();
            $table -> timestamps();
        });

        Schema ::create('table_orders', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('table_header')->nullable();
            $table -> string('column_name');
            $table -> integer('module_id') -> nullable();
            $table -> integer('template_id') -> nullable();
            $table -> boolean('active_status');
            $table -> boolean('is_numeric')->default(0);
            $table -> integer('order')->default(1)->nullable();
            $table -> timestamps();
        });

        Schema::create('book_keeping_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('realised_account_name')->default('Realised');
            $table->string('unrealised_account_name')->default('Unrealised');
            $table->string('balance_sheet_separator')->default(0);
            $table->integer('user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->timestamps();
        });

        Schema ::table('counterparties', function (Blueprint $table) {
            $table -> string('profit_center')->after('long_name') -> nullable();
        });

        Schema ::table('cost_centers', function (Blueprint $table) {
            $table -> string('voucher_name_id') -> nullable() -> after('long_name');
        });

        Schema::dropIfExists('bookkeeping_clients');
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('account_names');

        Schema ::dropIfExists('table_orders');

        Schema ::dropIfExists('book_keeping_settings');

        Schema ::table('counterparties', function (Blueprint $table) {
            $table -> dropColumn('profit_center');
        });

        Schema ::table('cost_centers', function (Blueprint $table) {
            $table -> dropColumn('voucher_name_id');
        });

        Schema::create('bookkeeping_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_account_number')->unique();
            $table->text('client_account_name');
            $table->boolean('balance_sheet');
            $table->integer('chartof_accounts_frame_id')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
