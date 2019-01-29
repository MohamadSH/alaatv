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
            $table->unsignedInteger('control_id')
                ->nullable()
                ->comment('آی دی مشخص کننده کنترل فیلد مثلا تکس باکس')
                ->after('displayName');
            $table->foreign('control_id')
                ->references('id')
                ->on('attributecontrols')
                ->onDelete('cascade')
                ->onupdate('cascade');
            $table->string('source')
                ->nullable()
                ->after('control_id')
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
