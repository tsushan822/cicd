<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends \Hyn\Tenancy\Abstracts\AbstractMigration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('customers', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('name');
            $table -> string('website_id');
            $table -> string('team_id') -> nullable();
            $table -> dateTime('trial_ends_at') -> nullable();
            $table -> string('database');
            $table -> string('fx_rate_source') -> nullable();
            $table -> boolean('active_status') ->default(1);
            $table -> text('user_domains') -> nullable();
            $table -> integer('voucher_month') ->default(6);
            $table -> dateTime('terms_accepted_at') ->default(now());
            $table -> text('terms_of_service');
            $table -> string('ip_address');
            $table -> integer('databond_client_id') -> nullable();
            $table -> integer('databond_source_id') -> nullable();
            $table -> boolean('databond_rate_import')->default(0);
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('customers');
    }
}
