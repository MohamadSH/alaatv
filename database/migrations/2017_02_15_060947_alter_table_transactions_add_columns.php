<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactionsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer("cost")
                  ->nullable()
                  ->comment("مبلغ تراکنش")
                  ->after("order_id");
            $table->string("traceNumber")
                  ->nullable()
                  ->comment("شماره پیگیری")
                  ->after("transactionID");
            $table->string("referenceNumber")
                  ->nullable()
                  ->comment("شماره مرجع")
                  ->after("traceNumber");
            $table->unsignedInteger('sourceBankAccount_id')
                  ->nullable()
                  ->comment("آی دی مشخص کننده شماره حساب مبدا")
                  ->after('managerComment');
            $table->unsignedInteger('destinationBankAccount_id')
                  ->nullable()
                  ->comment("آی دی مشخص کننده شماره حساب مقصد")
                  ->after('sourceBankAccount_id');
            $table->unsignedInteger('paymentmethod_id')
                  ->nullable()
                  ->comment("آی دی مشخص کننده روش پرداخت")
                  ->after('destinationBankAccount_id');

            $table->foreign('sourceBankAccount_id')
                  ->references('id')
                  ->on('bankaccounts')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('destinationBankAccount_id')
                  ->references('id')
                  ->on('bankaccounts')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('paymentmethod_id')
                  ->references('id')
                  ->on('paymentmethods')
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
            $table->dropForeign('transactions_sourcebankaccount_id_foreign');
            $table->dropForeign('transactions_destinationbankaccount_id_foreign');
            $table->dropForeign('transactions_paymentmethod_id_foreign');
            $table->dropColumn('traceNumber');
            $table->dropColumn('referenceNumber');
            $table->dropColumn('sourceBankAccount_id');
            $table->dropColumn('destinationBankAccount_id');
            $table->dropColumn('paymentmethod_id');
            $table->dropColumn('paid_at');
        });
    }
}
