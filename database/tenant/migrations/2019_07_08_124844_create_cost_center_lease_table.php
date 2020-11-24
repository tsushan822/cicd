<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostCenterLeaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema ::create('cost_center_lease', function (Blueprint $table) {
            $table -> integer('cost_center_id');
            $table -> integer('lease_id');
            $table -> integer('percentage');
            $table -> timestamps();
        });


        Schema ::table('admin_settings', function (Blueprint $table) {
            $table -> boolean('enable_cost_center_split') -> after('enable_failed_login_lock') ->default(false) -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists('cost_center_lease');

        Schema ::table('admin_settings', function (Blueprint $table) {
            $table -> dropColumn('enable_cost_center_split');
        });
    }
}
