<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEducationalcontentsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            $table->text('tmp_description')->after('description')->nullable()->comment('توضیحات موقت تایید نشده');
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
            Schema::table('educationalcontents', function (Blueprint $table) {
                if (Schema::hasColumn('educationalcontents', 'tmp_description')) {
                    $table->dropColumn('tmp_description');
                }
            });
        });
    }
}
