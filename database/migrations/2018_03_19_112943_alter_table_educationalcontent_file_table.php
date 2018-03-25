<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEducationalcontentFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontent_file', function (Blueprint $table)
        {
            $table->string("label")->nullable()->comment("لیبل فایل");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educationalcontent_file', function (Blueprint $table)
        {
            if (Schema::hasColumn('educationalcontent_file', 'label'))
            {
                $table->dropColumn('label');
            }
        });
    }
}
