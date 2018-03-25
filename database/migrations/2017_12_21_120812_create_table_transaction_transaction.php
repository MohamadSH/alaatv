<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_transaction', function (Blueprint $table) {
            $table->unsignedInteger('t1_id');
            $table->unsignedInteger('t2_id');
            $table->unsignedInteger('relationtype_id')->comment("آی دی مشخص کننده نوع رابطه");
            $table->primary(['t1_id','t2_id' , 'relationtype_id' ]);

            $table->foreign('t1_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('t2_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('relationtype_id')
                ->references('id')
                ->on('transactioninterraltions')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `transaction_transaction` comment 'جدول رابطه چند به چند بین تراکنش ها با یکدیگر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_transaction');
    }
}
