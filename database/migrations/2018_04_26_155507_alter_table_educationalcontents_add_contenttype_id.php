<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContentsAddContenttypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
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
        Schema::table('contents', function (Blueprint $table)
        {
            if (Schema::hasColumn('contents', 'contenttype_id'))
            {
                $table->dropForeign('contents_contenttype_id_foreign');
                $table->dropColumn('contenttype_id');
            }
        });
    }
}
