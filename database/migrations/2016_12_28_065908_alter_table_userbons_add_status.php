<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUserbonsAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('userbons', function ($table) {
            $table->unsignedInteger('userbonstatus_id')->nullable()->comment("آی دی مشخص کننده وضعیت این بن کاربر")->after('usedNumber');

            $table->foreign('userbonstatus_id')
                ->references('id')
                ->on('userbonstatuses')
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
        Schema::table('userbons', function ($table) {
            $table->dropColumn('userbonstatus_id');
        });
    }
}
