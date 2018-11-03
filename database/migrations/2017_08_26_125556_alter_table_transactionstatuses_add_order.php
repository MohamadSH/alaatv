<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactionstatusesAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactionstatuses', function (Blueprint $table) {
            $table->integer('order')
                  ->default(0)
                  ->comment('ترتیب')
                  ->after("displayName");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactionstatuses', function (Blueprint $table) {
            if (Schema::hasColumn('transactionstatuses', 'order')) {
                $table->dropColumn('order');
            }
        });
    }
}
