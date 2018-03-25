<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LotteryUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_user', function (Blueprint $table) {
            $table->unsignedInteger("lottery_id");
            $table->unsignedInteger("user_id");
            $table->integer("rank")->nullable()->comment("رتبه کاربر در قرعه کشی");
            $table->text("prizes")->nullable()->comment("جوایزی که کاربر برده است");
            $table->primary(['lottery_id','user_id' ]);

            $table->foreign('lottery_id')
                ->references('id')
                ->on('lotteries')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `lottery_user` comment 'رابطه چند به چند بین کاربران و قرعه کشی ها(شرکت در قرعه کشی)'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_user');
    }
}
