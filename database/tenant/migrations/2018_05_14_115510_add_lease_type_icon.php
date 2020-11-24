<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeaseTypeIcon extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_types', function (Blueprint $table) {
            $table -> string('lease_type_item') -> nullable() -> after('description');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_types', function (Blueprint $table) {
            $table -> dropColumn('lease_type_item');
        });
    }
}
