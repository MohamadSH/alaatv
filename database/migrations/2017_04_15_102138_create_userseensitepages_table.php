<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserseensitepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userseensitepages', function (Blueprint $table) {
            $table->unsignedInteger('user_id')
                  ->comment("آی دی مشخص کننده کاربر");
            $table->unsignedInteger('websitepage_id')
                  ->comment("آی دی مشخص کننده صفحه");
            $table->integer('numberOfVisit')
                  ->default(1)
                  ->comment("تعداد بازدید");
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('websitepage_id')
                  ->references('id')
                  ->on('websitepages')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `userseensitepages` comment 'هر کاربر از هر صفحه سایت چند بار بازدید کرده است'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userseensitepages');
    }
}
