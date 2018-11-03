<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableOrdersDropPaymentmethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_paymentmethod_id_foreign');
            $table->dropColumn('paymentmethod_id');
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
            $table->unsignedInteger('paymentmethod_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده روش پرداخت');

            $table->foreign('paymentmethod_id')
                  ->references('id')
                  ->on('paymentmethods')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
    }
}
