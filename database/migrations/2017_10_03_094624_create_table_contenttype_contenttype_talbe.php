<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContenttypeContenttypeTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenttype_contenttype', function (Blueprint $table) {
            $table->unsignedInteger('t1_id');
            $table->unsignedInteger('t2_id');
            $table->unsignedInteger('relationtype_id')->comment("آی دی مشخص کننده نوع رابطه");
            $table->primary(['t1_id','t2_id' , 'relationtype_id' ]);

            $table->foreign('t1_id')
                ->references('id')
                ->on('contenttypes')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('t2_id')
                ->references('id')
                ->on('contenttypes')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('relationtype_id')
                ->references('id')
                ->on('contenttypeinterrelations')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `contenttype_contenttype` comment 'رابطه یک نوع محتوا با نوع محتوای دیگر به همراه نوع رابطه'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenttype_contenttype');
    }
}
