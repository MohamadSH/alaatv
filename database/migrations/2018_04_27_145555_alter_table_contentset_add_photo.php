<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContentsetAddPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("contentsets", function (Blueprint $table)
        {
            $table->string("photo")->nullable()->comment("عکس پوستر")->after("description");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("contentsets", function (Blueprint $table)
        {
            if (Schema::hasColumn("products", 'photo'))
            {
                $table->dropColumn('photo');
            }
        });
    }
}
