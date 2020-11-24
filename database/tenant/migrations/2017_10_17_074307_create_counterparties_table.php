<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounterpartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counterparties', function (Blueprint $table) {
            $table->increments('id');
            $table->text('short_name');
            $table->text('long_name');
            $table->boolean('is_safe_keeper')->default(0);
            $table->boolean('is_counterparty')->default(1);
            $table->boolean('is_entity')->default(0);
            $table->boolean('is_parent_company')->default(0);
            $table->boolean('is_external')->default(0);
            $table->boolean('is_issuer')->default(0);
            $table->integer('currency_id')->unsigned();
            $table->text('o_code')->nullable();
            $table->text('lei')->nullable();
            $table->text('interim_identifier')->nullable();
            $table->text('bic')->nullable();
            $table->boolean('is_financial_company')->default(1);
            $table->boolean('is_corporate_sector')->default(1);
            $table->text('postal_address')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('uti_prefix')->nullable();
            $table->integer('limit_guarantee')->default(0);
            $table->text('dtc_id')->nullable();
            $table->text('alias_360t')->nullable();
            $table->text('alias_fxall')->nullable();
            $table->decimal('limit_extra',13,2)->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('counterparties');
    }
}
