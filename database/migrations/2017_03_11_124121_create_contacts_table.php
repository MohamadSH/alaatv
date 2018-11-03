<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده کاربر صاحب این رکورد دفترچه تلفن");
            $table->unsignedInteger("contacttype_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده نوع این رکورد دفترچه تلفن");
            $table->unsignedInteger("relative_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده نسبت صاحب اطالاعات تماس با کاربر");
            $table->string("name")
                  ->nullable()
                  ->comment("نام صاحب اطالاعات تماس");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('contacttype_id')
                  ->references('id')
                  ->on('contacttypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('relative_id')
                  ->references('id')
                  ->on('relatives')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `contacts` comment 'دفترچه تلفن کاربران'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
