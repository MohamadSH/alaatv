<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAttributevalueProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributevalue_product', function (Blueprint $table) {
            $table->unsignedInteger('attributevalue_id');
            $table->unsignedInteger('product_id');
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب صفت های محصول");
            $table->integer('extraCost')
                  ->nullable()
                  ->comment("اضافه قیمت به واسطه این صفت");
            $table->longText('description')
                  ->nullable()
                  ->comment("توضیحات");
            $table->primary([
                                'attributevalue_id',
                                'product_id',
                            ]);
            $table->timestamps();

            $table->foreign('attributevalue_id')
                  ->references('id')
                  ->on('attributevalues')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `attributevalue_product` comment 'رابطه چند به چند بین صفت ها و کالاها '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributevalue_product');
    }
}
