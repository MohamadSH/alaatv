<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableBonsAddBontype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bons', function ($table) {
            $table->unsignedInteger('bontype_id')
                  ->nullable()
                  ->comment("آی دی مشحص کننده نوع بن")
                  ->after('displayName');

            $table->foreign('bontype_id')
                  ->references('id')
                  ->on('bontypes')
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
        Schema::table('bons', function ($table) {
            if (Schema::hasColumn('bons', 'bontype_id')) {
                $table->dropForeign('bons_bontype_id_foreign');
                $table->dropColumn('bontype_id');
            }
        });
    }
}
