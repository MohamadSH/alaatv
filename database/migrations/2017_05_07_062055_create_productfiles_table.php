<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("product_id")
                  ->comment("آی دی مشخص کننده محصول این فایل");
            $table->string("file")
                  ->nullable()
                  ->comment("اسم فایل");
            $table->string("name")
                  ->nullable()
                  ->comment("عنوان فایل");
            $table->text("description")
                  ->nullable()
                  ->comment("توضیح درباره فایل");
            $table->tinyInteger("enable")
                  ->default(1)
                  ->comment("فعال بودن یا غیرفعال بودن فایل");
            $table->timestamp('validSince')
                  ->nullable()
                  ->comment("تاریخ شروع استفاده از فایل");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `productfiles` comment 'فایل های یک محصول برای کسی که سفارش داده'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productfiles');
    }
}
