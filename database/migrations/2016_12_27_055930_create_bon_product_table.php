<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_product', function (Blueprint $table) {
            $table->unsignedInteger('bon_id');
            $table->unsignedInteger('product_id');
            $table->integer('discount')->default(0)->comment("میزان تخفیف برای این محصول به واسطه این بن به درصد");
            $table->integer('bonPlus')->default(0)->comment("میزان تعداد اضافه شده از این بن به واسطه این محصول");
            $table->primary(['bon_id','product_id']);
            $table->timestamps();

            $table->foreign('bon_id')
                ->references('id')
                ->on('bons')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `bon_product` comment 'رابطه چند به چند محصولات و بن ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bon_product');
    }
}
