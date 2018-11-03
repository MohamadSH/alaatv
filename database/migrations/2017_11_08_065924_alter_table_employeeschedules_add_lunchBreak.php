<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmployeeschedulesAddLunchBreak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeeschedules', function (Blueprint $table) {
            $table->integer('lunchBreakInSeconds')
                  ->default(0)
                  ->comment('مدت زمان مجاز برای استراحت ناهار')
                  ->after("finishTime");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employeeschedules', function (Blueprint $table) {
            if (Schema::hasColumn('employeeschedules', 'lunchBreakInSeconds')) {
                $table->dropColumn('lunchBreakInSeconds');
            }
        });
    }
}
