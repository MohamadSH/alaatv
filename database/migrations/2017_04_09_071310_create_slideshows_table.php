<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideshowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->nullable();
            $table->string("shortDescription" , 200)->nullable();
            $table->string("photo")->nullable();
            $table->string("link")->nullable();
            $table->integer("order")->default(0);
            $table->tinyInteger("isEnable")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `phones` comment 'اسلایدهای نمایش داده شده در اسلاید شو های سایت'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slideshows');
    }
}
