<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName')
                  ->nullable()
                  ->comment('نام کوچک');
            $table->string('lastName')
                  ->nullable()
                  ->comment('نام خانوادگی');
            $table->string('mobile')
                  ->nullable()
                  ->comment('شماره موبایل');
            $table->tinyInteger('mobileNumberVerification')
                  ->default(0)
                  ->comment('شماره تماس تایید شده است یا خیر');
            $table->string('nationalCode')
                  ->nullable()
                  ->comment('کد ملی');
            $table->string('password')
                  ->comment('رمز عبور');
            $table->string('photo')
                  ->nullable()
                  ->comment('عکس شخصی');
            $table->string('province')
                  ->nullable()
                  ->comment('استان محل سکونت');
            $table->string('city')
                  ->nullable()
                  ->comment('شهر محل سکونت');
            $table->longText('address')
                  ->nullable()
                  ->comment('آدرس محل سکونت');
            $table->string('postalCode')
                  ->nullable()
                  ->comment('کد پستی محل سکونت');
            $table->string('school')
                  ->nullable()
                  ->comment('مدرسه ی محل تحصیل');
            $table->unsignedInteger('major_id')
                  ->nullable()
                  ->comment('آیدی رشته تحصیل کاربر');
            $table->unsignedInteger('gender_id')
                  ->nullable()
                  ->comment('آیدی جنیست کاربر');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                               'mobile',
                               'nationalCode',
                           ]);

            $table->foreign('major_id')
                  ->references('id')
                  ->on('majors')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('gender_id')
                  ->references('id')
                  ->on('genders')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `users` comment 'کاربران'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
