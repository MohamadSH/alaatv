<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMbtianswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mbtianswers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")
                  ->comment("آی دی مشخص کننده کاربری که آزمون داده است");
            $table->longText("answers")
                  ->nullable()
                  ->comment("آرایه ی مشخص کننده گزینه های انتخاب شده");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `mbtianswers` comment 'جدول موقتی برای ذخیره پاسخنامه آزمون خودشناسی کاربران'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mbtianswers');
    }
}
