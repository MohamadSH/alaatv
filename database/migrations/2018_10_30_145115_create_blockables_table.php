<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('blockables');
        Schema::create('blockables', function (Blueprint $table) {

            $table->unsignedInteger('block_id');
            $table->unsignedInteger('blockable_id');

            $table->string('blockable_type');
            $table->timestamps();

            $table->unique([
                               'block_id',
                               'blockable_id',
                               'blockable_type',
                           ]);

            $table->foreign('block_id')
                  ->references('id')
                  ->on('blocks')
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
        Schema::dropIfExists('blockables');
    }
}
