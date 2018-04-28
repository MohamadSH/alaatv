<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEducationalcontentsAddContenttypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            $table->unsignedInteger("contenttype_id")->nullable()->comment("آی دی مشخص کننده نوع محتوا")->after("author_id");

            $table->foreign('contenttype_id')
                ->references('id')
                ->on('contenttypes')
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
            if (Schema::hasColumn('educationalcontents', 'contenttype_id'))
            {
                $table->dropForeign('educationalcontents_contenttype_id_foreign');
                $table->dropColumn('contenttype_id');
            }
        });
    }
}
