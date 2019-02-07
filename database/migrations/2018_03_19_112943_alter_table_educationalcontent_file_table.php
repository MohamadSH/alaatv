<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEducationalcontentFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontent_file', function (Blueprint $table) {
            $table->string("label")
                  ->nullable()
                  ->comment("لیبل فایل");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educationalcontent_file', function (Blueprint $table) {
            if (Schema::hasColumn('educationalcontent_file', 'label')) {
                $table->dropColumn('label');
            }
        });
    }
}
