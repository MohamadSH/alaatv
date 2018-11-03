<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddPasswordRegeneratedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->dateTime('passwordRegenerated_at')
                  ->nullable()
                  ->comment("تاریخ آخرین تولید خودکار(بازیابی) رمز عبور")
                  ->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('passwordRegenerated_at');
        });
    }
}
