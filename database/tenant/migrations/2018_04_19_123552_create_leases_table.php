<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('leases', function (Blueprint $table) {
            $table -> increments('id') -> start_from(100000);
            $table -> boolean('ifrs_accounting')->default(1);
            $table -> decimal('lease_rate');
            $table -> decimal('borrowing_rate');
            $table -> integer('entity_id') -> nullable();
            $table -> integer('cost_center_id') -> nullable();
            $table -> integer('lease_type_id') -> nullable();
            $table -> integer('portfolio_id') -> nullable();
            $table -> decimal('lease_amount', 20,6) -> nullable();
            $table -> decimal('lease_service_cost', 20,6) -> nullable();
            $table -> decimal('total_lease', 20,6) -> nullable();
            $table -> integer('counterparty_id') -> nullable();
            $table -> integer('currency_id') -> nullable();
            $table -> integer('account_id') -> nullable();
            $table -> integer('payment_schedule') -> nullable();
            $table -> date('effective_date') -> nullable();
            $table -> date('maturity_date') -> nullable();
            $table -> date('first_payment_date') -> nullable();
            $table -> boolean('non_accountable') ->default(0);
            $table -> boolean('is_archived') ->default(0);
            $table -> boolean('calculate_valuation') ->default(0);
            $table -> text('text') -> nullable();
            $table -> boolean('user_id') ->default(0);
            $table -> boolean('updated_user_id') ->default(0);
            $table->string('agreement_type')->nullable();
            $table->date('contracts_first_possible_termination_day')->nullable();
            $table->integer('notice_period_in_months')->nullable();
            $table->date('lease_end_date')->nullable();
            $table->decimal('square_metres')->nullable();
            $table->decimal('grained_surface_area')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->integer('number_of_workstations')->nullable();
            $table->decimal('parking_cost_per_month')->nullable();
            $table->integer('number_of_parking_spaces')->nullable();
            $table->decimal('capital_rent_per_month')->nullable();
            $table->decimal('maintenance_rent_per_month')->nullable();
            $table->decimal('other_cost_per_month')->nullable();
            $table->decimal('total_costs_affecting_rent')->nullable();
            $table->string('renovation_and_rent_free_periods')->nullable();
            $table->decimal('rent_security_deposit')->nullable();
            $table->string('rent_security_type')->nullable();
            $table->date('rent_security_expiry_date')->nullable();
            $table->boolean('rent_security_received_back')->nullable();
            $table -> integer('lease_flow_per_year')->nullable();
            $table -> boolean('cost_center_split') ->default(false) -> nullable();
            $table -> string('internal_order') -> nullable();
            $table -> string('tax') -> nullable();
            $table -> string('rou_asset_number') -> nullable();
            $table->boolean('show_agreement_in_report')->default(1)->nullable();
            $table->string('source')->nullable();
            $table -> softDeletes();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::drop('leases');
    }
}
