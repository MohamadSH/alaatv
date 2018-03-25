<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationalcontentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educationalcontents', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->comment("نام محتوا");
            $table->text("description")->nullable()->comment("توضیح درباره محتوا");
            $table->integer("order")->default(0)->comment("ترتیب");
            $table->tinyInteger("enable")->default(1)->comment("فعال یا غیر فعال بودن محتوا");
            $table->timestamp('validSince')->nullable()->comment("تاریخ شروع استفاده از محتوا");
            $table->timestamps();
            $table->softDeletes();

        });
        DB::statement("ALTER TABLE `educationalcontents` comment 'جدول محتواهای آموزشی مانند جزوه و آزمون و غیره'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educationalcontents');
    }
}
