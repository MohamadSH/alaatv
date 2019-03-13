<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirebasetokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firebasetokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment("آیدی مشخص کننده کاربر صاحب توکن");
            $table->text('token')->nullable()->comment('توکن فایربیس');
            $table->timestamps();
            $table->softDeletes();

             $table->foreign('user_id')
                 ->references('id')
                 ->on('users')
                 ->onDelete('cascade')
                 ->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firebasetokens');
    }
}
