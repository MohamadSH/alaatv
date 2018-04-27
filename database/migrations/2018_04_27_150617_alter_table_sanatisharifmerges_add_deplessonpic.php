<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSanatisharifmergesAddDeplessonpic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("sanatisharifmerges", function (Blueprint $table)
        {
            $table->string("pic")->nullable()->comment("عکس دپلسن")->after("departmentlessonid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("sanatisharifmerges", function (Blueprint $table)
        {
            if (Schema::hasColumn("sanatisharifmerges", 'pic'))
            {
                $table->dropColumn('pic');
            }
        });
    }
}
