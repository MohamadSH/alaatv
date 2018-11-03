<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmployeetimesheetsAddAllowedLunchBreak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeetimesheets', function (Blueprint $table) {
            $table->integer('allowedLunchBreakInSec')
                  ->nullable()
                  ->comment('مدت زمان مجاز برای استراحت ناهار')
                  ->after("userFinishTime");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employeetimesheets', function (Blueprint $table) {
            if (Schema::hasColumn('employeetimesheets', 'allowedLunchBreakInSec')) {
                $table->dropColumn('allowedLunchBreakInSec');
            }
        });
    }
}
