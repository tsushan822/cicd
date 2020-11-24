<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id');
            $table->string('product_id');
            $table->string('plan_name')->nullable();
            $table->string('plan_description')->nullable();
            $table->string('add_ons');
            $table->string('services');
            $table->string('team_id')->nullable(false);
            $table->double('amount')->default(0.00);
            $table->integer('trial_days')->nullable()->default(null);
            $table->string('period');
            $table->string('features')->nullable()->default(null);
            $table->boolean('fx_rate')->nullable()->default(0);
            $table->integer('number_of_leases')->nullable()->default(0);
            $table->integer('number_of_users')->nullable()->default(0);
            $table->integer('number_of_companies')->nullable()->default(0);
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
        Schema::dropIfExists('custom_plans');
    }
}
