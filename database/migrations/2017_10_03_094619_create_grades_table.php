<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment("نام");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش");
            $table->text("description")
                  ->nullable()
                  ->comment("توضیح");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `grades` comment 'جدول مقاطع تحصیلی'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
