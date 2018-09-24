<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEducationalcontentsRemoveOrderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            if (!Schema::hasColumn('educationalcontents', 'order')) {
                $table->dropColumn('order');
            }
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
            //
        });
    }
}
