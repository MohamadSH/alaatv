<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMajorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام رشته');
            $table->longText('description')->nullable()->comment('توضیح درباره رشته');
            $table->tinyInteger('enable')->default(1)->comment('فعال بودن یا نبودن رشته');
            $table->integer('order')->default(0)->comment('ترتیب نمایش رشته - در صورت نیاز به استفاده');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `majors` comment 'رشته های تحصیلی'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majors');
    }
}
