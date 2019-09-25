<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSlideshowAddNewtab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slideshows', function (Blueprint $table) {
            $table->boolean('in_new_tab')->after('isEnable')->dufault(0)->comment('باز شدن لینک اسلاید شو در تب جدید');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slideshows', function (Blueprint $table) {
            if (Schema::hasColumn('slideshows', 'in_new_tab')) {
                $table->dropColumn('in_new_tab');
            }
        });
    }
}
