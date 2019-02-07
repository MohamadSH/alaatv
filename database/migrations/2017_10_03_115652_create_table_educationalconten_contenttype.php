<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableEducationalcontenContenttype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educationalcontent_contenttype', function (Blueprint $table) {
            $table->unsignedInteger('content_id');
            $table->unsignedInteger('contenttype_id');
            $table->primary([
                                'content_id',
                                'contenttype_id',
                            ]);

            $table->foreign('content_id')
                  ->references('id')
                  ->on('educationalcontents')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('contenttype_id')
                  ->references('id')
                  ->on('contenttypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `educationalcontent_contenttype` comment 'رابطه چند به چند محتواهای آموزشی با نوع محتوا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educationalcontent_contenttype');
    }
}
