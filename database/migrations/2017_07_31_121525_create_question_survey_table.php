<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_survey', function (Blueprint $table) {
            $table->unsignedInteger("survey_id");
            $table->unsignedInteger("question_id");
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب قرار گرفتن پرسش در مصاحبه");
            $table->tinyInteger("enable")
                  ->default(1)
                  ->comment("فعال یا غیر فعال بودن پرسش در مصاحبه");
            $table->text("description")
                  ->nullable()
                  ->comment("توضیح تکمیلی پرسش برای مصاحبه مورد نظر");
            $table->primary([
                                'survey_id',
                                'question_id',
                            ]);

            $table->foreign('survey_id')
                  ->references('id')
                  ->on('surveys')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('question_id')
                  ->references('id')
                  ->on('questions')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `question_survey` comment 'رابطه چند به چند مصاحبه ها و پرسش ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_survey');
    }
}
