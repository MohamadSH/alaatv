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
        Schema::create('content_major', function (Blueprint $table) {
            $table->unsignedInteger('content_id');
            $table->unsignedInteger('major_id');
            $table->primary(['content_id','major_id' ]);

            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('major_id')
                ->references('id')
                ->on('majors')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `content_major` comment 'رابطه چند به چند محتواهای آموزشی با رشته'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_major');
    }
}
