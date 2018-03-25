<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeschedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->comment("آیدی مشخص کننده کارمند");
            $table->string("day")->nullable()->comment("روز شیفت");
            $table->time("beginTime")->nullabe()->comment("زمان شروع ساعت کاری");
            $table->time("finishTime")->nullable()->comment("زمان پایان ساعت کاری");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `employeeschedules` comment 'جدول شیفت های کاری کارمندان'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeeschedules');
    }
}
