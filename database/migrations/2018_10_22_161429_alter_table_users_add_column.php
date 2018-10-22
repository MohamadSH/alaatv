<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'mobile_verified_code')) {
                $table->char('mobile_verified_code', 6)
                    ->nullable()
                    ->after('mobile')
                    ->comment("کد تایید شماره موبایل");
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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'mobile_verified_code')) {
                $table->dropColumn('mobile_verified_code');
            }
        });
    }
}
