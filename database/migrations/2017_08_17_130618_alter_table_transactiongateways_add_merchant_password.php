<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactiongatewaysAddMerchantPassword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactiongateways', function (Blueprint $table) {
            $table->string('merchantPassword')
                  ->nullable()
                  ->comment('رمز فروشنده')
                  ->after("merchantNumber");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(' transactiongateways', function (Blueprint $table) {
            if (Schema::hasColumn('transactiongateways', 'merchantPassword')) {
                $table->dropColumn('merchantPassword');
            }
        });
    }
}
