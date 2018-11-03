<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWorkdaytypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workdaytypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام نوع");
            $table->text("description")
                  ->nullable()
                  ->comment("توضیح درباره این نوع");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `workdaytypes` comment 'جدول انواع مختلف روزهای کاری'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workdaytypes');
    }
}
