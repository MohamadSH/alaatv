<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEducationalcontentsAddColumns extends Migration
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
            $table->text('file')
                ->nullable()
                ->comment("فایل های هر محتوا")
                ->after("context");

            $table->time('duration')
                ->comment("مدت زمان فیلم")
                ->after("file");
        });
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
        });
    }
}
