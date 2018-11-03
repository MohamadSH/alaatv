<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSanatisharifmergesAddDeplessonpic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("sanatisharifmerges", function (Blueprint $table) {
            $table->string("pic")
                  ->nullable()
                  ->comment("عکس دپلسن")
                  ->after("departmentlessonid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("sanatisharifmerges", function (Blueprint $table) {
            if (Schema::hasColumn("sanatisharifmerges", 'pic')) {
                $table->dropColumn('pic');
            }
        });
    }
}
