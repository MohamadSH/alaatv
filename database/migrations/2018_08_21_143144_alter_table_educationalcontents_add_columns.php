<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{
    Log, Schema
};

class AlterTableContentsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            if (!Schema::hasColumn('contents', 'file')) {
                $table->text('file')
                    ->nullable()
                    ->comment("فایل های هر محتوا")
                    ->after("context");
            }
            if (!Schema::hasColumn('contents', 'duration')) {
                $table->time('duration')
                    ->comment("مدت زمان فیلم")
                    ->after("file");
            }
            if (!Schema::hasColumn('contents', 'thumbnail')) {
                $table->text('thumbnail')
                    ->nullable()
                    ->comment("عکس هر محتوا")
                    ->after("duration");
            }
            if (!Schema::hasColumn('contents', 'isFree')) {
                $table->boolean('isFree')
                    ->default(true)
                    ->comment("عکس هر محتوا")
                    ->after("thumbnail");
            }
        });

        $contents = \App\Content::all();
        foreach ($contents as $content) {
            try {
                $content->fixFiles();
            } catch (Exception $e) {
                Log::error("Content-" . $content->id . ":\n\r" . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            if (Schema::hasColumn('contents', 'file')) {
                $table->dropColumn('file');
            }
            if (Schema::hasColumn('contents', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('contents', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
            if (Schema::hasColumn('contents', 'isFree')) {
                $table->dropColumn('isFree');
            }
        });
    }
}
