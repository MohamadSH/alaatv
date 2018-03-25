<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderproductUserbonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderproduct_userbon', function (Blueprint $table) {
            $table->unsignedInteger('orderproduct_id')->comment("آی دی آیتم سبدی که بن برای آن استفاده شده");
            $table->unsignedInteger('userbon_id')->comment("آی دی بن استفاده شده برای این آیتم سبد");
            $table->integer('usageNumber')->default(0)->comment("تعداد استفاده شده از بن مشخص شده برای این آیتم سبد") ;

            $table->foreign('userbon_id')
                ->references('id')
                ->on('userbons')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('orderproduct_id')
                ->references('id')
                ->on('orderproducts')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `orderproduct_userbon` comment 'رابطه چند به چند بین آیتم های سفارش(سبد) و بنهای استفاده شده برای آن'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderproduct_userbon');
    }
}
