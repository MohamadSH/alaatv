<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام کپن');
            $table->longText('description')->nullable()->comment('توضیحات کپن');
            $table->string('code')->nullable()->unique()->comment('کد کپن') ;
            $table->integer('discount')->default(0)->comment('میزان تخفیف کپن به درصد');
            $table->integer('usageLimit')->nullable()->comment('حداکثر تعداد مجاز تعداد استفاده از کپن - اگر نال باشد یعنی نامحدود');
            $table->integer('usageNumber')->default(0)->comment('تعداد استفاده ها از کپن تا این لحظه');
            $table->dateTime('validSince')->nullable()->comment('تاریخ شروع معتبر بودن کپن') ;
            $table->dateTime('validUntil')->nullable()->comment('تاریخ پایان معتبر بودن کپن');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `coupons` comment 'کپن های تحفیف'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
