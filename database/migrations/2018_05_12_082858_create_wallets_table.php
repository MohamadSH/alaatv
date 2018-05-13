<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->nullable()->comment("آیدی مشخص کننده کاربر صاحب کیف پول");
            $table->unsignedInteger("wallettype_id")->nullable()->comment("آیدی مشخص کننده نوع کیف پول");
            $table->bigInteger('balance');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id','wallettype_id'] );

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('wallettype_id')
                ->references('id')
                ->on('wallettypes')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `wallets` comment 'جدول کیف پول ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
