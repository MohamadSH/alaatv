<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRolesAddIsDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->tinyInteger('isDefault')->default(0)->comment('آیا نقش سیستمی است(نقش پیش فرض سیستمی)')->after("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(' roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'isDefault')) {
                $table->dropColumn('isDefault');
            }
        });
    }
}
