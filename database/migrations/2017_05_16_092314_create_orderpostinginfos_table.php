<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderpostinginfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderpostinginfos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')
                  ->comment("آی دی مشخص کننده سفارش این پست");
            $table->unsignedInteger('user_id')
                  ->comment("آی دی مشخص کننده مسئول درج کننده اطلاعات پستی");
            $table->string('postCode')
                  ->nullable()
                  ->comment("کد پست (شماره مرسوله)");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `orderpostinginfos` comment 'اطلاعات پستی مرسوله یک سفارش'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderpostinginfos');
    }
}
