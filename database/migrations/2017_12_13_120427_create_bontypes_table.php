<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBontypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bontypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->unique()->comment("نام نوع بن") ;
            $table->string("displayName")->nullable()->comment("نام قابل نمایش نوع بن") ;
            $table->string("description")->nullable()->comment("توضیح درباره نوع بن") ;
            $table->timestamps();
            $table->softDeletes() ;
        });
        DB::statement("ALTER TABLE `bontypes` comment 'جدول نوع بن ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bontypes');
    }
}
