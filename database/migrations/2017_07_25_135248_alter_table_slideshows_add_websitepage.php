<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSlideshowsAddWebsitepage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slideshows', function (Blueprint $table) {
            $table->unsignedInteger('websitepage_id')->nullable()->comment("آی دی مشخص کننده صفحه محل نمایش اسلاید")->after("id");

            $table->foreign('websitepage_id')
                ->references('id')
                ->on('websitepages')
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
        Schema::table('slideshows', function (Blueprint $table) {
            $table->dropColumn('websitepage_id');
        });
    }
}
