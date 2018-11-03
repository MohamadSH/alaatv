<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderproductOrderproduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderproduct_orderproduct', function (Blueprint $table) {
            $table->unsignedInteger('op1_id');
            $table->unsignedInteger('op2_id');
            $table->unsignedInteger('relationtype_id')
                  ->comment("آی دی مشخص کننده نوع رابطه");
            $table->primary([
                                'op1_id',
                                'op2_id',
                                'relationtype_id',
                            ]);

            $table->foreign('op1_id')
                  ->references('id')
                  ->on('orderproducts')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('op2_id')
                  ->references('id')
                  ->on('orderproducts')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('relationtype_id')
                  ->references('id')
                  ->on('orderproductinterrelations')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `orderproduct_orderproduct` comment 'رابطه یک آیتم سبد با آیتم دیگر به همراه نوع رابطه'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderproduct_orderproduct');
    }
}
