<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده کاربر سفارش دهنده');
            $table->unsignedInteger('orderstatus_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده وضعیت سفارش');
            $table->unsignedInteger('paymentstatus_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده وضعیت پرداخت سفارش');
            $table->unsignedInteger('paymentmethod_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده روش پرداخت');
            $table->unsignedInteger('coupon_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده کپن استفاده شده برای سفارش');
            $table->integer('cost')
                  ->nullable()
                  ->comment('مبلغ قابل پرداخت توسط کاربر');
            $table->longText('customerDescription')
                  ->nullable()
                  ->comment('توضیحات مشتری درباره سفارش');
            $table->dateTime('checkOutDateTime')
                  ->nullable()
                  ->comment('تاریخ تسویه حساب کامل');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('orderstatus_id')
                  ->references('id')
                  ->on('orderstatuses')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('paymentstatus_id')
                  ->references('id')
                  ->on('paymentstatuses')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('paymentmethod_id')
                  ->references('id')
                  ->on('paymentmethods')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('coupon_id')
                  ->references('id')
                  ->on('coupons')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `orders` comment 'سبد خرید'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
