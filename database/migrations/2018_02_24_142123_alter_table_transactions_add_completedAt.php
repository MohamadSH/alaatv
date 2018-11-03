<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactionsAddCompletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp("deadline_at")
                  ->nullable()
                  ->comment("مهلت پرداخت")
                  ->after("created_at");
            $table->timestamp("completed_at")
                  ->nullable()
                  ->comment("تاریخ پرداخت")
                  ->after("deadline_at");
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
            if (Schema::hasColumn('transactions', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            if (Schema::hasColumn('transactions', 'deadline_at')) {
                $table->dropColumn('deadline_at');
            }
        });
    }
}
