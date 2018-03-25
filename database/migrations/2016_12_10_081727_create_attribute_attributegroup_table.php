<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeAttributegroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_attributegroup', function (Blueprint $table) {
            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('attributegroup_id');
            $table->unsignedInteger("attributetype_id")->nullable()->comment("آی دی مشخص کننده نوع صفت مورد نظر") ;
            $table->integer("order")->default(0)->comment("ترتیب صفت");
            $table->primary(['attribute_id','attributegroup_id']);
            $table->timestamps();

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('attributegroup_id')
                ->references('id')
                ->on('attributegroups')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('attributetype_id')
                ->references('id')
                ->on('attributetypes')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `attribute_attributegroup` comment 'رابطه چند به چند بین صفت ها و گروه های آنها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_attributegroup');
    }
}
