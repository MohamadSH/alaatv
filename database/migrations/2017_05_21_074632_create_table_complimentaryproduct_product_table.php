<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComplimentaryproductProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complimentaryproduct_product', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('complimentary_id')->comment("آی دی مشخص کننده محصول اشانتیون");
            $table->primary(['product_id','complimentary_id']);
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('complimentary_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `complimentaryproduct_product` comment 'محصولات اشانتیون یک محصول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complimentaryproduct_product');
    }
}
