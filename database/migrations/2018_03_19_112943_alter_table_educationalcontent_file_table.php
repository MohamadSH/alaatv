<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableContentFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_file', function (Blueprint $table) {
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
        Schema::table('content_file', function (Blueprint $table) {
            if (Schema::hasColumn('content_file', 'label')) {
                $table->dropColumn('label');
            }
        });
    }
}
