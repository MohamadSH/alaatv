<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEducationalcontentFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educationalcontent_file', function (Blueprint $table) {
            $table->unsignedInteger('content_id');
            $table->unsignedInteger('file_id');
            $table->string('caption')->nullable()->comment("کپشن مورد نظر جهت نمایش برای این فایل");
            $table->primary(['content_id','file_id' ]);

            $table->foreign('content_id')
                ->references('id')
                ->on('educationalcontents')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educationalcontent_file');
    }
}
