<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContentsetContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contentset_content', function (Blueprint $table) {
            $table->unsignedInteger('contentset_id');
            $table->unsignedInteger('edc_id');
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب");
            $table->tinyInteger("isDefault")
                  ->default(0)
                  ->comment("مشخص کننده دسته پیش فرض");
            $table->primary([
                                'contentset_id',
                                'edc_id',
                            ]);

            $table->foreign('contentset_id')
                  ->references('id')
                  ->on('contentsets')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('edc_id')
                  ->references('id')
                  ->on('contents')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `contentset_content` comment 'رابطه چند به چند دسته محتوا با محتوا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contentset_content');
    }
}
