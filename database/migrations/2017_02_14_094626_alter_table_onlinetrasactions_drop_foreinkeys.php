<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableOnlinetrasactionsDropForeinkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('onlinetransactions', function (Blueprint $table) {
            $table->dropForeign('onlinetransactions_order_id_foreign');
            $table->dropForeign('onlinetransactions_onlinetransactiongateway_id_foreign');
            $table->dropForeign('onlinetransactions_transactionstatus_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onlinetransactions', function (Blueprint $table) {
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('onlinetransactiongateway_id')
                  ->references('id')
                  ->on('onlinetransactiongateways')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('transactionstatus_id')
                  ->references('id')
                  ->on('transactionstatuses')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
    }
}
