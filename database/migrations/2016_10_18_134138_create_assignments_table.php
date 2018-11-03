<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام تمرین');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح درباره تمرین');
            $table->string('numberOfQuestions')
                  ->nullable()
                  ->comment('تعداد سؤالات تمرین');
            $table->string('recommendedTime')
                  ->nullable()
                  ->comment('وقت پیشنهادی برای حل سؤالات تمرین');
            $table->string('questionFile')
                  ->nullable()
                  ->comment('فایل سوالات تمرین');
            $table->string('solutionFile')
                  ->nullable()
                  ->comment('فایل پاسخنامه(حل) تمرین');
            $table->string('analysisVideoLink')
                  ->nullable()
                  ->comment('لینک صفحه تماشای فیلم تجزیه و تحلیل تمرین');
            $table->integer('order')
                  ->default(0)
                  ->comment('ترتیب تمرین - در صورت نیاز به استفاده');
            $table->tinyInteger('enable')
                  ->default(1)
                  ->comment('فعال بودن یا نبودن تمرین');
            $table->unsignedInteger('assignmentstatus_id')
                  ->comment('آیدی مشخص کننده وضعیت تمرین');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assignmentstatus_id')
                  ->references('id')
                  ->on('assignmentstatuses')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });

        DB::statement("ALTER TABLE `assignments` comment 'تمرین ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
