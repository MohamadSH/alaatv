<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWorktimesheetsAddOvertimestatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeetimesheets', function (Blueprint $table) {
            $table->unsignedInteger('overtime_status_id')->nullable()->comment('وضعیت اضافه کاری');

            $table->foreign('overtime_status_id')
                ->references('id')
                ->on('employeeovertimestatus')
                ->onDelete('cascade')
                ->onupdate('cascade');
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
            if (Schema::hasColumn('employeetimesheets', 'overtime_status_id')) {
                $table->dropForeign('employeetimesheets_overtime_status_id_foreign');
                $table->dropColumn('overtime_status_id');
            }
        });
    }
}
