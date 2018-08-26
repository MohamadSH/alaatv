<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContentAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->unsignedInteger("template_id")->nullable()->comment("آی دی مشخص کننده قالب این گرافیکی این محتوا")->after("id");
            $table->unsignedInteger("author_id")->nullable()->comment("آی دی مشخص کننده به وجود آورنده اثر")->after("id");
            $table->string("metaTitle")->nullable()->comment("متا تایتل محتوا")->after("description");
            $table->string("metaDescription")->nullable()->comment("متا دیسکریپشن محتوا")->after("metaTitle");
            $table->string("metaKeywords")->nullable()->comment("متای کلمات کلیدی محتوا")->after("metaDescription");
            $table->text("tags")->nullable()->comment("تگ ها")->after("metaKeywords");

            $table->foreign('template_id')
                ->references('id')
                ->on('templates')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('author_id')
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
        Schema::table('contents', function (Blueprint $table)
        {
            if (Schema::hasColumn('contents', 'template_id'))
            {
                $table->dropForeign('contents_template_id_foreign');
                $table->dropColumn('template_id');
            }
            if (Schema::hasColumn('contents', 'author_id'))
            {
                $table->dropForeign('contents_author_id_foreign');
                $table->dropColumn('author_id');
            }
            if (Schema::hasColumn('contents', 'metaTitle'))
            {
                $table->dropColumn('metaTitle');
            }
            if (Schema::hasColumn('contents', 'metaDescription'))
            {
                $table->dropColumn('metaDescription');
            }
            if (Schema::hasColumn('contents', 'metaKeywords'))
            {
                $table->dropColumn('metaKeywords');
            }
            if (Schema::hasColumn('contents', 'tags'))
            {
                $table->dropColumn('tags');
            }
        });
    }
}
