<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bons', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment('نام بن');
            $table->string("displayName")
                  ->nullable()
                  ->comment('نام قابل نمایش بن');
            $table->longText("description")
                  ->nullable()
                  ->comment("توضیح درباره بن");
            $table->tinyInteger("isEnable")
                  ->default(1)
                  ->comment("فعال/غیرفعال");
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب بن");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `bons` comment 'بن های تخفیف'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bons');
    }
}
