<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment("نام قرعه کشی");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش قرعه کشی");
            $table->timestamp("holdingDate")
                  ->nullable()
                  ->comment("تاریخ برگزاری");
            $table->integer("essentialPoints")
                  ->default(0)
                  ->comment("تعداد امتیاز لازم برای شرکت در قرعه کشی");
            $table->text("prizes")
                  ->nullable()
                  ->comment("جوایز قرعه کشی");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `lotteries` comment 'جدول قرعه کشی ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotteries');
    }
}
