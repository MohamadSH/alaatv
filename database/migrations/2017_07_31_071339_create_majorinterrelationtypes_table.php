<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMajorinterrelationtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majorinterrelationtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment("نام نوع");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش نوع");
            $table->string("description")
                  ->nullable()
                  ->comment("توضیح درباره این نوع رابطه");
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `majorinterrelationtypes` comment 'انواع مختلف رابطه دو رشته با یکدیگر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majorinterrelationtypes');
    }
}
