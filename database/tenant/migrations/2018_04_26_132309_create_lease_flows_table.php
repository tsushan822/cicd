<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaseFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lease_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('payment_date')->nullable();
            $table->decimal('fixed_payment',20,6);
            $table->decimal('fees',20,6)->nullable();
            $table->decimal('interest_rate',4,2)->nullable();
            $table->text('description')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('lease_id');
            $table->boolean('locked')->default(0);
            $table -> integer('lease_extension_id') -> nullable() ->default(0);
            $table -> decimal('liability_opening_balance', 20, 6) -> nullable();
            $table -> decimal('interest_cost', 20, 6) -> nullable();
            $table -> decimal('liability_closing_balance', 20, 6) -> nullable();
            $table -> decimal('variations', 20, 6) -> nullable();
            $table->integer('user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lease_flows', function (Blueprint $table) {
            $table->dropIfExists('lease_flows');
        });
    }
}
