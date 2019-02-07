<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEducationalcontentAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            $table->unsignedInteger("template_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده قالب این گرافیکی این محتوا")
                  ->after("id");
            $table->unsignedInteger("author_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده به وجود آورنده اثر")
                  ->after("id");
            $table->string("metaTitle")
                  ->nullable()
                  ->comment("متا تایتل محتوا")
                  ->after("description");
            $table->string("metaDescription")
                  ->nullable()
                  ->comment("متا دیسکریپشن محتوا")
                  ->after("metaTitle");
            $table->string("metaKeywords")
                  ->nullable()
                  ->comment("متای کلمات کلیدی محتوا")
                  ->after("metaDescription");
            $table->text("tags")
                  ->nullable()
                  ->comment("تگ ها")
                  ->after("metaKeywords");

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
        Schema::table('educationalcontents', function (Blueprint $table) {
            if (Schema::hasColumn('educationalcontents', 'template_id')) {
                $table->dropForeign('educationalcontent_template_id_foreign');
                $table->dropColumn('template_id');
            }
            if (Schema::hasColumn('educationalcontents', 'author_id')) {
                $table->dropForeign('educationalcontent_author_id_foreign');
                $table->dropColumn('author_id');
            }
            if (Schema::hasColumn('educationalcontents', 'metaTitle')) {
                $table->dropColumn('metaTitle');
            }
            if (Schema::hasColumn('educationalcontents', 'metaDescription')) {
                $table->dropColumn('metaDescription');
            }
            if (Schema::hasColumn('educationalcontents', 'metaKeywords')) {
                $table->dropColumn('metaKeywords');
            }
            if (Schema::hasColumn('educationalcontents', 'tags')) {
                $table->dropColumn('tags');
            }
        });
    }
}
