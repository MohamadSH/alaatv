<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmployeetimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeetimesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")
                  ->comment('آیدی مشخص کننده کارمند');
            $table->date("date")
                  ->comment("تاریخ ساعت کاری");
            $table->time("userBeginTime")
                  ->nullable()
                  ->comment("ساعت شروع شیفت کارمند");
            $table->time("userFinishTime")
                  ->nullable()
                  ->comment("ساعت پایان شیفت کارمند");
            $table->time("clockIn")
                  ->nullable()
                  ->comment("زمان ورود به محل کار");
            $table->time("beginLunchBreak")
                  ->nullable()
                  ->comment("زمان خروج برای استراحت ناهار");
            $table->time("finishLunchBreak")
                  ->nullable()
                  ->comment("زمان پایان استراحت ناهار");
            $table->time("clockOut")
                  ->nullable()
                  ->comment("زمان خروج از مجل کار");
            $table->integer("breakDurationInSeconds")
                  ->default(0)
                  ->comment("زمان استراحت و کسری ساعت کاری بر حسب ثانیه");
            $table->tinyInteger("timeSheetLock")
                  ->default(0)
                  ->comment("قفل بودن ساعت کاری");
            $table->unsignedInteger("workdaytype_id")
                  ->nullable()
                  ->comment("نوع روز کاری");
            $table->tinyInteger("isPaid")
                  ->default(1)
                  ->comment("مشخص کننده تسویه یا تسویه ساعت کاری");
            $table->text("managerComment")
                  ->nullable()
                  ->comment("توضیحات مدیر");
            $table->text("employeeComment")
                  ->nullable()
                  ->comment("توضیح کارمند");
            $table->unsignedInteger("modifier_id")
                  ->nullable()
                  ->comment("آیدی مشخص کننده کاربری که آخرین بار رکورد را اصلاح کرده است");
            $table->timestamps();
            $table->softDeletes();
            $table->unique([
                               'user_id',
                               'date',
                           ]);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('modifier_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('workdaytype_id')
                  ->references('id')
                  ->on('workdaytypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `employeetimesheets` comment 'جدول ساعت کاری کامندان'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeetimesheets');
    }
}
