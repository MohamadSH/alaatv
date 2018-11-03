<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserbonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userbons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bon_id')
                  ->comment("آی دی مشخص کننده بن تخصیص داده شده");
            $table->unsignedInteger('user_id')
                  ->comment("آی دی مشخص کننده کاربری که بن به او تخصیص داده شده");
            $table->integer("totalNumber")
                  ->default(0)
                  ->comment("تعداد بن اختصاص داده شده به کاربر");
            $table->integer("usedNumber")
                  ->default(0)
                  ->comment("تعداد بنی که کاربر استفاده کرده");
            $table->dateTime("validSince")
                  ->nullable()
                  ->comment("زمان شروع استفاده از کپن ، نال به معنای شروع از زمان ایجاد است");
            $table->dateTime("validUntil")
                  ->nullable()
                  ->comment("زمان پایان استفاده از کپن ، نال به معنای بدون محدودیت می باشد");
            $table->unsignedInteger("orderproduct_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده آیتمی که به واسطه آن این بن به کاربر اختصاص داده شده");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bon_id')
                  ->references('id')
                  ->on('bons')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('orderproduct_id')
                  ->references('id')
                  ->on('orderproducts')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `userbons` comment 'بن های اختصاص داده شده به هر کاربر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userbons');
    }
}
