<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->comment("آی دی مشخص کننده فرد ایجاد کننده مقاله");
            $table->unsignedInteger('articlecategory_id')->nullable()->comment("آی دی مشخص کننده دسته بندی مقاله");
            $table->string('title')->nullable()->comment("عنوان مقاله");
            $table->string('keyword')->nullable()->comment("کلمات کلیدی مقاله");
            $table->string('brief')->nullable()->comment("خلاصه مقاله");
            $table->longText('body')->nullable()->comment("متن مقاله");
            $table->string('image')->nullable()->comment("تصویر مقاله");
            $table->timestamps();
            $table->softDeletes();



            $table->foreign('articlecategory_id')
                ->references('id')
                ->on('articlecategories')
                ->onDelete('cascade')
                ->onupdate('cascade');


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });

        DB::statement("ALTER TABLE `articles` comment 'مقاله '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
