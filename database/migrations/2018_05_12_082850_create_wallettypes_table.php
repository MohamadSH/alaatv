<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWallettypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallettypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->unique()->comment("نام") ;
            $table->string("displayName")->nullable()->comment("نام قابل نمایش") ;
            $table->string("description")->nullable()->comment("توضیح کوتاه") ;
            $table->timestamps();
            $table->softDeletes() ;
        });
        DB::statement("ALTER TABLE `wallettypes` comment 'جدول انواع کیف پول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallettypes');
    }
}
