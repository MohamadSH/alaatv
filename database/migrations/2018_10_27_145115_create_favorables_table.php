<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavorablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('favorable_id');
            $table->string('favorable_type');
            $table->timestamps();

            $table->unique([
                               'user_id',
                               'favorable_id',
                               'favorable_type',
                           ]);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('favorables');
    }
}
