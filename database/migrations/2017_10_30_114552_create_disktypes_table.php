<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDisktypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disktypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->unique()
                  ->comment("نام نوع دیسک");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `disktypes` comment 'جدول نوع دیسک ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disktypes');
    }
}
