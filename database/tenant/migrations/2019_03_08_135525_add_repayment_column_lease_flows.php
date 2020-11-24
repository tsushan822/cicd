<?php

use App\Zen\Lease\Model\Lease;
use App\Zen\Lease\Service\LeaseFlowService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepaymentColumnLeaseFlows extends Migration
{
    use \App\Zen\System\Traits\ConfigDatabase;

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema ::table('lease_flows', function (Blueprint $table) {
            $table -> decimal('total_payment', 20, 6) ->default('0') -> after('fees');
            $table -> decimal('repayment', 20, 6) ->default('0') -> after('total_payment');
            $table -> decimal('short_term_liability', 20, 6) ->default('0') -> after('repayment');
        });


        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> decimal('monthly_depreciation', 20, 6) ->default('0') -> after('extension_penalties_for_terminating');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema ::table('lease_flows', function (Blueprint $table) {
            $table -> dropColumn(['repayment', 'short_term_liability', 'total_payment']);
        });
        Schema ::table('lease_extensions', function (Blueprint $table) {
            $table -> dropColumn(['monthly_depreciation']);
        });
    }
}
