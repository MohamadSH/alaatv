<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOvertimeConfirmationToEmployeetimesheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeetimesheets', function (Blueprint $table) {
            $table->boolean('overtime_confirmation')
                ->default(false)
                ->comment('تاییدیه اضافه کاری')
                ->after('modifier_id');
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
            $table->dropColumn('overtime_confirmation');
        });
    }
}
