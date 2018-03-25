<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->comment("نام رخداد");
            $table->longText("description")->nullable()->comment("توضیح درباره رخداد");
            $table->timestamp("startTime")->nullable()->comment("زمان شروع");
            $table->timestamp("endTime")->nullable()->comment("زمان پایان");
            $table->tinyInteger("enable")->default(1)->comment("فعال یا غیر فعال بودن");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `events` comment 'جدول رخدادها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
