<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableChildproductParentProductAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('childproduct_parentproduct', function (Blueprint $table) {
            $table->unsignedInteger('control_id')
                  ->nullable()
                  ->comment('آیدی مشخص کننده کنترل انتخاب محصول فرزند(با توجه به نوع محصول والد)')
                  ->after("isDefault");
            $table->string("description")
                  ->nullable()
                  ->comment('توضیحات انتخاب محصول فرزند')
                  ->after("control_id");

            $table->foreign('control_id')
                  ->references('id')
                  ->on('attributecontrols')
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
        Schema::table('childproduct_parentproduct', function (Blueprint $table) {
            if (Schema::hasColumn('childproduct_parentproduct', 'control_id')) {
                $table->dropForeign('childproduct_parentproduct_control_id_foreign');
                $table->dropColumn('description');
            }
        });
    }
}
