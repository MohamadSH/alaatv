<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseruploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useruploads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment("آی دی مشخص کننده کاربر آپلود کننده فایل");
            $table->string("file")->nullable()->comment("فایل آپلود شده");
            $table->string("title")->nullable()->comment("عنوان وارد شده کاربر برای این آپلود");
            $table->longText("comment")->nullable()->comment("توضیح وارد شده کاربر درباره آپلود");
            $table->longText("staffComment")->nullable()->comment("توضیح مسئول درباره فایل");
            $table->tinyInteger("isEnable")->default(1)->comment("فعال / غیر فعال");
            $table->unsignedInteger("useruploadstatus_id")->nullable()->comment("وضعیت فایل");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('useruploadstatus_id')
                ->references('id')
                ->on('useruploadstatuses')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `useruploads` comment 'فایل های آپلود شده توسط کاربران'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('useruploads');
    }
}
