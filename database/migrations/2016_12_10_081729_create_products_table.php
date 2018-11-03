<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام  کالا');
            $table->integer('basePrice')
                  ->default(0)
                  ->comment('قیمت پایه  کالا');
            $table->longText('shortDescription')
                  ->nullable()
                  ->comment('توضیحات مختصر کالا');
            $table->longText('longDescription')
                  ->nullable()
                  ->comment('توضیحات کالا');
            $table->string('slogan')
                  ->nullable()
                  ->comment('یک جمله ی خاص درباره این کالا');
            $table->string('image')
                  ->nullable()
                  ->comment('تصویر اصلی کالا');
            $table->string('file')
                  ->nullable()
                  ->comment('فایل مربوط به کالا');
            $table->dateTime('validSince')
                  ->nullable()
                  ->comment('تاریخ شروع فروش کالا');
            $table->dateTime('validUntil')
                  ->nullable()
                  ->comment('تاریخ پایان فروش کالا');
            $table->smallInteger('enable')
                  ->default(1)
                  ->comment('فعال بودن یا نبودن کالا');
            $table->integer('order')
                  ->default(0)
                  ->comment('ترتیب کالا - در صورت نیاز به استفاده');
            $table->unsignedInteger('producttype_id')
                  ->nullable()
                  ->comment('آی دی مشخص کننده نوع کالا');
            $table->unsignedInteger('attributeset_id')
                  ->nullable()
                  ->comment('آی دی مشخص کننده دسته صفتهای کالا');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('producttype_id')
                  ->references('id')
                  ->on('producttypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('attributeset_id')
                  ->references('id')
                  ->on('attributesets')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `products` comment 'هر آنچه فروشی است'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
