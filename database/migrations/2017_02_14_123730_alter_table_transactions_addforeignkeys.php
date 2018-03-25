<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactionsAddforeignkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('transactiongateway_id')
                ->references('id')
                ->on('transactiongateways')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('transactionstatus_id')
                ->references('id')
                ->on('transactionstatuses')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('onlinetransactions_transactiongateway_id_foreign');
            $table->dropForeign('onlinetransactions_order_id_foreign');
            $table->dropForeign('onlinetransactions_transactionstatus_id_foreign');
        });
    }
}
