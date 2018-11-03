<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableOrdersAddCustomerExtraInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->longText("customerExtraInfo")
                  ->nullable()
                  ->comment("اطلاعات تکمیلی مشتری برای این سفارش")
                  ->after("customerDescription");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'customerExtraInfo')) {
                $table->dropColumn('customerExtraInfo');
            }
        });
    }
}
