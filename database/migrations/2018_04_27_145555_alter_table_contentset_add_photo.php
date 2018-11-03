<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableContentsetAddPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("contentsets", function (Blueprint $table) {
            $table->string("photo")
                  ->nullable()
                  ->comment("عکس پوستر")
                  ->after("description");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("contentsets", function (Blueprint $table) {
            if (Schema::hasColumn("products", 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
}
