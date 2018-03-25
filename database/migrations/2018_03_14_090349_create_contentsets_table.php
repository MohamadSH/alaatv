<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contentsets', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->comment("نام");
            $table->string("description")->nullable()->comment("توضیح");
            $table->tinyInteger("enable")->default(1)->comment("فعال/غیرفعال");
            $table->tinyInteger("display")->default(1)->comment("نمایش/عدم نمایش");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `contentsets` comment 'دسته های محتوا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contentsets');
    }
}
