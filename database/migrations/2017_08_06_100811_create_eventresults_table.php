<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventresults', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('آی دی مشخص کننده کاربر');
            $table->unsignedInteger('event_id')->comment('آی دی مشخص کننده رخداد');
            $table->integer('rank')->nullable()->comment('رتبه کاربر در کنکور');
            $table->string('participationCode')->nullable()->comment('شماره داوطلبی کاربر در رخداد');
            $table->string('reportFile')->nullable()->comment('فایل کارنامه کاربر');
            $table->tinyInteger('enableReportPublish')->nullable()->comment('اجازه یا عدم اجازه انتشار کارنامه و نتیجه');
            $table->text('comment')->nullable()->comment('نظر کاربر درباره نتیجه و رخداد');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `eventresults` comment 'نتایج شرکت کنند گان یک رخداد'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventresults');
    }
}
