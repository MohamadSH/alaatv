<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserTableAddUserstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->unsignedInteger('userstatus_id')->after('password')->comment('آیدی مشخص کننده وضعیت کاربر');
            $table->foreign('userstatus_id')
                ->references('id')->on('userstatuses')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('userstatus_id');
            $table->dropColumn('userstatus_id');
        });
    }
}
