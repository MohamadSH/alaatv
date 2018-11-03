<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVerificationmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificationmessages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")
                  ->comment("آی دی مشخص کننده کاربر گیرنده پیام");
            $table->string("code")
                  ->nullable()
                  ->comment("کد ارسال شده به کاربر");
            $table->unsignedInteger("verificationmessagestatus_id")
                  ->nullable()
                  ->comment("وضعیت پیام");
            $table->dateTime("expired_at")
                  ->nullable()
                  ->comment("زمان انقضای کد ارسال شده");
            $table->timestamps();

            $table->foreign('verificationmessagestatus_id')
                  ->references('id')
                  ->on('verificationmessagestatuses')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `verificationmessages` comment 'پیام های تایید حساب کاربری ارسال شده به کاربران'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verificationmessages');
    }
}
