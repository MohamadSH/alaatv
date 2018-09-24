<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEducationalcontenContenttype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_contenttype', function (Blueprint $table) {
            $table->unsignedInteger('content_id');
            $table->unsignedInteger('contenttype_id');
            $table->primary(['content_id','contenttype_id' ]);

            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('contenttype_id')
                ->references('id')
                ->on('contenttypes')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `content_contenttype` comment 'رابطه چند به چند محتواهای آموزشی با نوع محتوا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_contenttype');
    }
}
