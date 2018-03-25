<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("control_id")->nullable()->comment("آی دی مشخص کننده نوع کنترل این پرسش");
            $table->string("dataSourceUrl")->nullable()->comment("لینک منبع داده کنترل این پرسش");
            $table->string("querySourceUrl")->nullable()->comment("لینک منبع کوئری برای این پرسش");
            $table->string("statement")->nullable()->comment("صورت پرسش");
            $table->string("title")->nullable()->comment("یک عنوان برای پرسش");
            $table->text("description")->nullable()->comment("توضیح درباره پرسش");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('control_id')
                ->references('id')
                ->on('attributecontrols')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `questions` comment 'جدول پرسش ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
