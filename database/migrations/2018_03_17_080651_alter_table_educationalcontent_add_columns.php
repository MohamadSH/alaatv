<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedInteger("template_id")->nullable()->comment("آی دی مشخص کننده قالب این گرافیکی این محتوا");
            $table->string("metaTitle")->nullable()->comment("متا تایتل محتوا");
            $table->string("metaDescription")->nullable()->comment("متا دیسکریپشن محتوا");
            $table->string("metaKeywords")->nullable()->comment("متای کلمات کلیدی محتوا");

            $table->foreign('template_id')
                ->references('id')
                ->on('templates')
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
        Schema::table('educationalcontents', function (Blueprint $table)
        {
            if (Schema::hasColumn('educationalcontents', 'template_id'))
            {
                $table->dropForeign('educationalcontents_template_id_foreign');
                $table->dropColumn('template_id');
            }
            if (Schema::hasColumn('educationalcontents', 'metaTitle'))
            {
                $table->dropColumn('metaTitle');
            }
            if (Schema::hasColumn('educationalcontents', 'metaDescription'))
            {
                $table->dropColumn('metaDescription');
            }
            if (Schema::hasColumn('educationalcontents', 'metaKeywords'))
            {
                $table->dropColumn('metaKeywords');
            }
        });
    }
}
