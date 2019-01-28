<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributecontrolsIdToAfterloginformcontrolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('afterloginformcontrols', function (Blueprint $table) {
            $table->unsignedInteger('attributecontrols_id');
            $table->foreign('attributecontrols_id')
                ->references('id')
                ->on('attributecontrols')
                ->onDelete('cascade');
            $table->string('source')
                ->nullable()
                ->comment('مسیر سرور جهت تغذیه فیلد (مثلا تغذیه آیتم های دراپ دان)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('afterloginformcontrols', function (Blueprint $table) {
            $table->dropColumn('attributecontrols_id');
            $table->dropColumn('source');
        });
    }
}
