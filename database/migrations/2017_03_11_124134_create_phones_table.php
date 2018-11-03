<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("contact_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده رکورد دفترچه تلفن صاحب شماره");
            $table->unsignedInteger("phonetype_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده نوع شماره");
            $table->string('phoneNumber')
                  ->nullable()
                  ->comment('شماره تلفن');
            $table->Integer('priority')
                  ->default(0)
                  ->comment('اولویت شماره ها در میان نوع خود مثلا یک شماره موبایل در بین موبایلهای صاحب شماره ، 0 به معنی بالاترین اولویت');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contact_id')
                  ->references('id')
                  ->on('contacts')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('phonetype_id')
                  ->references('id')
                  ->on('phonetypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `phones` comment 'شماره تلفن '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
