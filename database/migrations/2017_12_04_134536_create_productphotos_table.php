<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductphotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productphotos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment("آیدی مشخص کننده محصول عکس");
            $table->string("file")->nullable()->comment("فایل عکس");
            $table->string("title")->nullable()->comment("تایتل عکس");
            $table->string("description")->nullalbe()->comment("توضیح کوتاه یا تیتر دوم عکس");
            $table->tinyInteger("order")->default(0)->comment("ترتیب عکس");
            $table->tinyInteger("enable")->default(1)->comment("فعال/غیر فعال بودن عکس");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productphotos');
    }
}
