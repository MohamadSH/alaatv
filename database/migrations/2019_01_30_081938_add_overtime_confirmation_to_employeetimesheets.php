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
        if (!Schema::hasColumn('employeetimesheets', 'overtime_confirmation')) {
            Schema::table('employeetimesheets', function (Blueprint $table) {
                $table->boolean('overtime_confirmation')
                      ->default(false)
                      ->comment('تاییدیه اضافه کاری')
                      ->after('modifier_id');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('employeetimesheets', 'overtime_confirmation')) {
            Schema::table('employeetimesheets', function (Blueprint $table) {
                $table->dropColumn('overtime_confirmation');
            });
        }
    }
}
