<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')
                  ->comment('آی دی مشخص کننده سفارشی که این فایل به آن تعلق دارد');
            $table->unsignedInteger('user_id')
                  ->nullable()
                  ->comment('آی دی مشخص کننده کاربر آپلود کننده فایل');
            $table->string('file')
                  ->comment('فایل آپلود شده');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح درباره فایل');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `orderfiles` comment 'فایل های سفارش'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderfiles');
    }
}
