<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBankaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankaccounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده کاربر صاحب حساب");
            $table->unsignedInteger("bank_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده بانک حساب");
            $table->string("accountNumber")
                  ->unique()
                  ->nullable()
                  ->comment("شاره حساب");
            $table->string("cardNumber")
                  ->unique()
                  ->nullable()
                  ->comment("شماره کارت اعتباری حساب");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('bank_id')
                  ->references('id')
                  ->on('banks')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `bankaccounts` comment 'شماره حساب ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bankaccounts');
    }
}
