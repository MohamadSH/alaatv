<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOnlinetransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlinetransactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("order_id")
                  ->comment('آیدی مشخص کننده سفارشی که از طریق این تراکنش مبلغ آن پرداخت شده است');
            $table->string('authority')
                  ->nullable()
                  ->unique()
                  ->comment('شماره اتوریتی تولید شده از طرف درگاه');
            $table->string('transactionID')
                  ->nullable()
                  ->unique()
                  ->comment('کد پیگیری تراکنش');
            $table->longText('managerComment')
                  ->nullable()
                  ->comment('توضیح مسئول درباره تراکنش');
            $table->unsignedInteger('onlinetransactiongateway_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده درگاه تراکنش');
            $table->unsignedInteger('transactionstatus_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده وضعیت تراکنش');
            $table->timestamps();
            $table->softDeletes();

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
        DB::statement("ALTER TABLE `onlinetransactions` comment 'تراکنش های بانکی آنلاین'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onlinetransactions');
    }
}
