<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactionsAddWalletid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger("wallet_id")
                ->nullable()
                ->comment("آیدی مشخص کننده کیف پولی که تراکنش متعلق به آن است")
                ->after("order_id");
            $table->unsignedInteger("order_id")
                ->nullable()
                ->comment("آیدی مشخص کننده سفارشی که تراکنش متعلق به آن است")
                ->change();
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

            if (Schema::hasColumn('transactions', 'wallet_id'))
            {
                $table->dropForeign('transactions_wallet_id_foreign');
                $table->dropColumn('wallet_id');
            }

            $table->unsignedInteger("order_id")
                ->comment("آیدی مشخص کننده سفارشی که از طریق این تراکنش مبلغ آن پرداخت شده است")
                ->change();
        });
    }
}
