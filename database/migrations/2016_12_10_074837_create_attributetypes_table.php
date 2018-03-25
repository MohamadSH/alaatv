<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment("نام این نوع");
            $table->longText('description')->nullable()->comment("توضیح درباره این نوع");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `attributetypes` comment 'انواع مختلف یک صفت'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributetypes');
    }
}
