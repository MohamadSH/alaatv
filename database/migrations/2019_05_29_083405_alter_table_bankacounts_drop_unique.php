<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBankacountsDropUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bankaccounts', function (Blueprint $table) {
            $table->dropUnique('bankaccounts_accountNumber_unique');
            $table->dropUnique('bankaccounts_cardNumber_unique');
            $table->unique([ 'user_id' ,'accountNumber' , 'cardNumber']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bankaccounts', function (Blueprint $table) {
            if (Schema::hasColumn('bankaccounts', 'accountNumber')) {
                $table->unique('accountNumber');
            }

            if (Schema::hasColumn('bankaccounts', 'cardNumber')) {
                $table->unique('cardNumber');
            }

            if (Schema::hasColumns('bankaccounts', ['accountNumber' , 'user_id' , 'cardNumber'])) {
                $table->dropUnique('bankaccounts_user_id_accountNumber_cardNumber_unique');
            }

        });
    }
}
