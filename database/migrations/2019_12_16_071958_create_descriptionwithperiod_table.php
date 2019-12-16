<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionwithperiodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptionwithperiods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable()->comment('آی دی محصول');
            $table->timestamp('since')->nullable()->comment('شروع بازه');
            $table->timestamp('till')->nullable()->comment('پایان بازه');
            $table->text('description')->nullable()->comment('توضیح');
            $table->unsignedInteger('staff_id')->nullable()->comment('آی دی درج کننده توضیح');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('staff_id')
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

        DB::statement("ALTER TABLE `descriptionwithperiods` comment 'توضیحات بازه ای'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descriptionwithperiods');
    }
}
