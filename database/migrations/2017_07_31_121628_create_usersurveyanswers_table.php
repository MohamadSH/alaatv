<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersurveyanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersurveyanswers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->comment("آی دی مشخص کننده کاربر پاسخ دهنده");
            $table->unsignedInteger("question_id")->comment("آی دی مشخص کننده پرسش مربرط به پاسخ");
            $table->unsignedInteger("survey_id")->comment("آی دی مشخص کننده مصاحبه مربوط به پاسخ");
            $table->unsignedInteger("event_id")->comment("آی دی مشخص کننده رخداد مربرط به پاسخ");
            $table->text("answer")->nullable()->comment("پاسخ کاربر");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('survey_id')
                ->references('id')
                ->on('surveys')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `usersurveyanswers` comment 'جدول پرسش ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usersurveyanswers');
    }
}
