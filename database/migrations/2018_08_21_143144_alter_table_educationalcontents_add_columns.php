<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{
    Log, Schema
};

class AlterTableEducationalContentsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            if (!Schema::hasColumn('educationalcontents', 'file')) {
                $table->text('file')
                    ->nullable()
                    ->comment("فایل های هر محتوا")
                    ->after("context");
            }
            if (!Schema::hasColumn('educationalcontents', 'duration')) {
                $table->time('duration')
                    ->comment("مدت زمان فیلم")
                    ->after("file");
            }
            if (!Schema::hasColumn('educationalcontents', 'thumbnail')) {
                $table->text('thumbnail')
                    ->nullable()
                    ->comment("عکس هر محتوا")
                    ->after("duration");
            }
            if (!Schema::hasColumn('educationalcontents', 'isFree')) {
                $table->boolean('isFree')
                    ->default(true)
                    ->comment("عکس هر محتوا")
                    ->after("thumbnail");
            }
            if (!Schema::hasColumn('educationalcontents', 'slug')) {
                $table->string('slug',250)
                    ->nullable()
                    ->comment("slug")
                    ->after("name");
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
        Schema::table('educationalcontents', function (Blueprint $table) {
            if (Schema::hasColumn('educationalcontents', 'file')) {
                $table->dropColumn('file');
            }
            if (Schema::hasColumn('educationalcontents', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('educationalcontents', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
            if (Schema::hasColumn('educationalcontents', 'isFree')) {
                $table->dropColumn('isFree');
            }
            if (Schema::hasColumn('educationalcontents', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
}
