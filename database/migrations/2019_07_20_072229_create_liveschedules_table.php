<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liveschedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dayofweek_id')->nullable()->comment('آی دی مشخص کننده روز هفته');
            $table->string('title')->nullable()->comment('عنوان لایو');
            $table->string('description')->nullable()->comment('توضیح درباره لایو');
            $table->string('poster')->nullable()->comment('پوستر لایو');
            $table->time('start_time')->nullable()->comment('ساعت شروع لایو');
            $table->time('finish_time')->nullable()->comment('ساع لایو');
            $table->date('first_live')->nullable()->comment('تاریخ اولین رویداد');
            $table->date('last_live')->nullable()->comment('تاریخ آخرین رویداد');
            $table->boolean('enable')->default(1)->comment('فعال یا غیرفعال');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dayofweek_id')
                ->references('id')
                ->on('dayofweek')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });

        DB::statement("ALTER TABLE `liveschedules` comment 'کنداکتور برنامه های زنده'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("liveschedules", function (Blueprint $table) {
            if (Schema::hasColumn("liveschedules", 'dayofweek_id')) {
                $table->dropForeign('liveschedules_dayofweek_id_foreign');
            }
        });

        Schema::dropIfExists('liveschedules');
    }
}
