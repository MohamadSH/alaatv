<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable()->comment('آیدی محصول');
            $table->string('title')->nullable()->comment('عنوان');
            $table->longText('body')->nullable()->comment('متن');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });

        DB::statement("ALTER TABLE `faqs` comment 'سوالات متداول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}
