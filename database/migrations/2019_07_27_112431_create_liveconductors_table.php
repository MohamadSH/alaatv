<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveconductorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liveconductors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment('عنوان برنامه');
            $table->string('description')->nullable()->comment('توضیح درباره برنامه');
            $table->string('poster')->nullable()->comment('پوستر برنامه');
            $table->date('date')->nullable()->comment('تاریخ لایو');
            $table->time('scheduled_start_time')->nullable()->comment('زمان شروع برنامه در جدول برنامه ها');
            $table->time('scheduled_finish_time')->nullable()->comment('زمان شروع برنامه در جدول برنامه ها');
            $table->time('start_time')->nullable()->comment('زمان شروع برنامه');
            $table->time('finish_time')->nullable()->comment('زمان پایان برنامه');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `liveconductors` comment 'کنداکتور پخش زنده'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liveconductors');
    }
}
