<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableEducationalcontentGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educationalcontent_grade', function (Blueprint $table) {
            $table->unsignedInteger('content_id');
            $table->unsignedInteger('grade_id');
            $table->primary([
                                'content_id',
                                'grade_id',
                            ]);

            $table->foreign('content_id')
                  ->references('id')
                  ->on('educationalcontents')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('grade_id')
                  ->references('id')
                  ->on('grades')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `educationalcontent_grade` comment 'رابطه چند به چند محتواهای آموزشی با مقطع'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educationalcontent_grade');
    }
}
