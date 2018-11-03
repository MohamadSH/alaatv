<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChildproductParentproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('childproduct_parentproduct', function (Blueprint $table) {
            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('child_id');
            $table->primary([
                                'parent_id',
                                'child_id',
                            ]);
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('child_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `childproduct_parentproduct` comment 'رابطه چند به چند بین محصولات والد و محصولات فرزند'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('childproduct_parentproduct');
    }
}
