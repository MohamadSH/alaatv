<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->comment('کاربر طرف قرارداد');
            $table->unsignedInteger('product_id')->nullable()->comment('محصول قرارداد');
            $table->unsignedInteger('registerer_id')->nullable()->comment('کاربر ثبت کننده قرارداد');
            $table->string('name')->nullable()->comment('نام قرارداد');
            $table->string('description')->nullable()->comment('توضیح درباره قرارداد');
            $table->timestamp('since')->nullable()->comment('شروع قرارداد');
            $table->timestamp('till')->nullable()->comment('اتمام قرارداد');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');


            $table->foreign('registerer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');

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
        Schema::dropIfExists('contracts');
    }
}
