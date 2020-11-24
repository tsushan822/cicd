<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteUniqueLeaseTypes extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_types', function (Blueprint $table) {
            $table -> dropUnique('lease_types_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_types', function (Blueprint $table) {
            $table -> string('type') -> unique() -> change();
        });
    }
}
