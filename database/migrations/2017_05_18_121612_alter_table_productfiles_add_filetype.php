<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductfilesAddFiletype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productfiles', function (Blueprint $table) {
            $table->unsignedInteger('productfiletype_id')
                  ->nullable()
                  ->comment("آی دی مشخص کننده نوع فایل")
                  ->after('product_id');

            $table->foreign('productfiletype_id')
                  ->references('id')
                  ->on('productfiletypes')
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
        Schema::table('productfiles', function (Blueprint $table) {
            $table->dropForeign('productfiles_productfiletype_id_foreign');
            $table->dropColumn('productfiletype_id');
        });
    }
}
