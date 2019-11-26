<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEducationalcontentsAddDisplay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            $table->boolean('display')->after('enable')->default(1)->comment('نمایش یا عدم نمایش');
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
            if (Schema::hasColumn('educationalcontents', 'display')) {
                $table->dropColumn('display');
            }
        });
    }
}
