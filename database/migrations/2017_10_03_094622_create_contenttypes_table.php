<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContenttypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenttypes', function (Blueprint $table) {
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
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب");
            $table->tinyInteger("enable")
                  ->default(1)
                  ->comment("فعال یا غیر فعال");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `contenttypes` comment 'جدول گونه های محتوا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenttypes');
    }
}
