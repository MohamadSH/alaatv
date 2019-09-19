<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactionsAddDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('device_id')->nullable()->comment('آی دی دیوایس کاربر')->after('paymentmethod_id');

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
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
            if (Schema::hasColumn('transactions', 'device_id')) {
                $table->dropForeign('transactions_device_id_foreign');
                $table->dropColumn('device_id');
            }
        });
    }
}
