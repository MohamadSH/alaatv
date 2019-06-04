<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWalletAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->integer('pending_to_reduce')->default(0)->after('balance')->comment('مبلغی که علی الحساب از کیف پول کم شده است');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            if (Schema::hasColumn('wallets', 'pending_to_reduce')) {
                $table->dropColumn('pending_to_reduce');
            }
        });
    }
}
