<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeaseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lease_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable()->unique();
            $table->string('description')->nullable();
            $table -> decimal('lease_valuation_rate', 20, 6)->nullable();
            $table -> string('interest_calculation_method') ->default('Simple') -> nullable();
            $table -> string('payment_type') ->default('In arrears');
            $table->boolean('extra_payment_in_fees')->default(0)->nullable();
            $table->boolean('exclude_first_payment')->default(0)->nullable();
            $table -> integer('user_id') -> nullable();
            $table -> integer('updated_user_id') -> nullable();
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
        Schema::drop('lease_types');
    }
}
