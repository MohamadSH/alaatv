<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributevalueOrderproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributevalue_orderproduct', function (Blueprint $table) {
            $table->unsignedInteger('value_id');
            $table->unsignedInteger('orderproduct_id');
            $table->integer("order")->default(0)->comment("ترتیب صفت های سفارش سبد");
            $table->integer('extraCost')->nullable()->comment("اضافه قیمت به واسطه این صفت");
            $table->longText('description')->nullable()->comment("توضیحات");
            $table->primary(['value_id','orderproduct_id']);
            $table->timestamps();

            $table->foreign('value_id')
                ->references('id')
                ->on('attributevalues')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('orderproduct_id')
                ->references('id')
                ->on('orderproducts')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `attributevalue_orderproduct` comment 'رابطه چند به چند بین  صفت ها و سفارش های سبد '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributevalue_orderproduct');
    }
}
