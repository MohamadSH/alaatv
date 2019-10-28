<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_product', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->comment('آیدی محصول');
            $table->unsignedInteger('block_id')->comment('آیدی بلاک');
            $table->tinyInteger('order')->default(0)->comment('ترتیب بلاک');
            $table->boolean('enable')->default(1)->comment('فعال بودن بلاک');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('block_id')
                ->references('id')
                ->on('blocks')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });

        DB::statement("ALTER TABLE `block_product` comment 'جدول بین محصولات و  بلاک ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_product');
    }
}
