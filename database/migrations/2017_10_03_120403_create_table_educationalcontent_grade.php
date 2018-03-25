<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger('educationalcontent_id');
            $table->unsignedInteger('grade_id');
            $table->primary(['educationalcontent_id','grade_id' ]);

            $table->foreign('educationalcontent_id')
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
