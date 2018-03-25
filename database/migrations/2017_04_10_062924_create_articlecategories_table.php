<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlecategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlecategories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment("نام دسته بندی");
            $table->longText('description')->nullable()->comment("توضیح دسته بندی مقالات");
            $table->tinyInteger('enable')->default(1)->comment("فعال بودن یا نبودن دسته");
            $table->tinyInteger('order')->default(0)->comment("ترتیب دسته");
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `articlecategories` comment 'دسته بندی '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articlecategories');
    }
}
