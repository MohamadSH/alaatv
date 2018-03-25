<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product', function (Blueprint $table) {
            $table->unsignedInteger('p1_id');
            $table->unsignedInteger('p2_id');
            $table->unsignedInteger('relationtype_id')->comment("آی دی مشخص کننده نوع رابطه");
            $table->primary(['p1_id','p2_id' , 'relationtype_id' ]);

            $table->foreign('p1_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('p2_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('relationtype_id')
                ->references('id')
                ->on('productinterrelations')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `product_product` comment 'رابطه یک محصول با محصول دیگر به همراه نوع رابطه'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_product');
    }
}
