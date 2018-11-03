<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام جنیست');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح جنسیت');
            $table->integer('order')
                  ->default(0)
                  ->comment('ترتیب');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `genders` comment 'جنسیت های مختلف'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}
