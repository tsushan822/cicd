<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeaseExtensionTypeColumns extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> string('lease_extension_type') -> after('lease_extension_rate') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> dropColumn('lease_extension_type');
        });
    }
}
