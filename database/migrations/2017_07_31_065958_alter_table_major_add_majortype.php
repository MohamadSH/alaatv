<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableMajorAddMajortype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('majors', function ($table) {
            $table->unsignedInteger('majortype_id')
                  ->nullable()
                  ->comment("آی دی مشخص کننده نوع رشته")
                  ->after('name');

            $table->foreign('majortype_id')
                  ->references('id')
                  ->on('majortypes')
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
        Schema::table('majors', function ($table) {
            $table->dropForeign('majors_majortype_id_foreign');
            $table->dropColumn('majortype_id');
        });
    }
}
