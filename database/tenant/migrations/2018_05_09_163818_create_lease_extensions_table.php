<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaseExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::create('lease_extensions', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('lease_id');
            $table -> date('date_of_change');
            $table -> date('extension_start_date')->nullable();
            $table -> date('extension_end_date') -> nullable();
            $table -> decimal('extension_period_amount', 20, 6) -> nullable();
            $table -> decimal('extension_service_cost', 20, 6) -> nullable();
            $table -> decimal('extension_total_cost', 20, 6) -> nullable();
            $table -> decimal('lease_extension_rate', 20, 6) -> nullable();
            $table -> integer('user_id') -> nullable();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('lease_extensions');
    }
}
