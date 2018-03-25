<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanatisharifmergesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanatisharifmerges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('videoid')->nullable()->comment("آی دی مشخص کننده یک فیلم");
            $table->tinyInteger('videoTransferred')->default(0)->comment("فیلم به تخته خاک منتقل شده یا خیر؟");
            $table->string('videoname')->nullable()->comment("نام فیلم");
            $table->longText('videodescrip')->nullable()->comment("توضیح فیلم");
            $table->integer('videosession')->default(0)->comment("جلسه فیلم");
            $table->string('keywords')->nullable()->comment("کلمات کلیدی فیلم");
            $table->string('videolink')->nullable()->comment("آدرس فایل hd فیلم");
            $table->string('videolinkhq')->nullable()->comment("آدرس فایل hq فیلم");
            $table->string('videolink240p')->nullable()->comment("آدرس فایل 240p فیلم");
            $table->tinyInteger("videoEnable")->nullable()->comment("فعال بودن یا نبودن فیلم");
            $table->string('thumbnail')->nullable()->comment("آدرس فایل تامبنیل فیلم");
            $table->unsignedInteger('pamphletid')->nullable()->comment("آی دی مشخص کننده یک جزوه");
            $table->tinyInteger('pamphletTransferred')->default(0)->comment("جزوه به تخته خاک منتقل شده یا خیر؟");
            $table->string('pamphletname')->nullable()->comment("نام جزوه");
            $table->string('pamphletaddress')->nullable()->comment("آدرس فایل جزوه");
            $table->string('pamhpletdescrip')->nullable()->comment("توضیح فیلم");
            $table->tinyInteger("isexercise")->default(0)->comment("فایل جزوه یک آزمون است یا خیر");
            $table->unsignedInteger('lessonid')->nullable()->comment("آی دی مشخص کننده درس");
            $table->tinyInteger('lessonTransferred')->default(0)->comment("درس به تخته خاک منتقل شده یا خیر؟");
            $table->string('lessonname')->nullable()->comment("نام درس");
            $table->tinyInteger("lessonEnable")->nullable()->comment("فعال بودن یا نبودن درس");
            $table->unsignedInteger('depid')->nullable()->comment("آی دی مشخص کننده مقطع");
            $table->tinyInteger('departmentTransferred')->default(0)->comment("مقطع به تخته خاک منتقل شده یا خیر؟");
            $table->string('depname')->nullable()->comment("نام مقطع");
            $table->string('depyear')->nullable()->comment("سال مقطع");
            $table->unsignedInteger('departmentlessonid')->nullable()->comment("آی دی مشخص کننده درس دپارتمان");
            $table->tinyInteger('departmentlessonTransferred')->default(0)->comment("درس دپارتمان به تخته خاک منتقل شده یا خیر؟");
            $table->tinyInteger("departmentlessonEnable")->nullable()->comment("فعال بودن یا نبودن درس دپارتمان");
            $table->string('teacherfirstname')->nullable()->comment("نام کوچک دبیر");
            $table->string('teacherlastname')->nullable()->comment("نام خانوادگی دبیر");
            $table->string('pageOldAddress')->nullable()->comment("آدرس قدیم صفحه");
            $table->string('pageNewAddress')->nullable()->comment("آدرس جدید صفحه");
            $table->unsignedInteger('educationalcontent_id')->nullable()->comment("آدرس محتوای نظیر در صورت وجود");
            $table->unique(['videoid','pamphletid','lessonid','depid','departmentlessonid'] , 'unique_columns_set');
            $table->unique(['videoid','departmentlessonid'] );
            $table->unique(['pamphletid','departmentlessonid']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('educationalcontent_id')
                ->references('id')
                ->on('educationalcontents')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `sanatisharifmerges` comment 'جدولی ادغام شده از دیتاهای ضروری آلاء برای سینک'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanatisharifmerges');
    }
}
