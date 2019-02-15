<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_user', function (Blueprint $table) {
            $table->unsignedInteger('permission_id')
                  ->comment('آیدی مشخص کننده دسترسی مورد نظر');
            $table->unsignedInteger('user_id')
                  ->comment('آیدی مشخص کننده کاربری که دسترسی را به او می دهیم');
            $table->dateTime('expire_at')
                  ->nullable()
                  ->comment('زمان انقضای دسترسی');
            $table->timestamps();

            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permissions')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `permission_user` comment 'اختصاص دسترسی به کاربر به صورت مدت دار و بدون در نظر گرفتن نقش کاربر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
    }
}
