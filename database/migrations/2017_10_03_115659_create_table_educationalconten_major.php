<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEducationalcontenMajor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educationalcontent_major', function (Blueprint $table) {
            $table->unsignedInteger('educationalcontent_id');
            $table->unsignedInteger('major_id');
            $table->primary(['educationalcontent_id','major_id' ]);

            $table->foreign('educationalcontent_id')
                ->references('id')
                ->on('educationalcontents')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('major_id')
                ->references('id')
                ->on('majors')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `educationalcontent_major` comment 'رابطه چند به چند محتواهای آموزشی با رشته'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educationalcontent_major');
    }
}
