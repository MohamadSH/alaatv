<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEventSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_survey', function (Blueprint $table) {
            $table->unsignedInteger("event_id");
            $table->unsignedInteger("survey_id");
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب قرار گرفتن مصاحبه در رخداد");
            $table->tinyInteger("enable")
                  ->default(1)
                  ->comment("فعال یا غیر فعال بودن مصاحبه در رخداد");
            $table->text("description")
                  ->nullable()
                  ->comment("توضیح تکمیلی مصاحبه برای رخداد مورد نظر");
            $table->primary([
                                'event_id',
                                'survey_id',
                            ]);

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `event_survey` comment 'رابطه چند به چند رخدادها و مصاحبه ها'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_survey');
    }
}
