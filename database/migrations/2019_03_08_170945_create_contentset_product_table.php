<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsetProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contentset_product', function (Blueprint $table) {
            $table->unsignedInteger('contentset_id');
            $table->unsignedInteger('product_id');
            $table->integer("order")
                ->default(0)
                ->comment("ترتیب");
        
            $table->timestamps();
            $table->softDeletes();
    
            $table->foreign('contentset_id')
                ->references('id')
                ->on('contentsets')
                ->onDelete('cascade')
                ->onupdate('cascade');
        
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');
    
            $table->unique([
                'contentset_id',
                'product_id',
            ]);
        
        
        });
        DB::statement("ALTER TABLE `contentset_product` comment 'رابطه چند به چند دسته محتوا با محصول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contentset_product');
    }
}
