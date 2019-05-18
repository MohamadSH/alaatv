<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(tickets_table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->text('content')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_open')->default(1);
            $table->integer('agent_id')->unsigned();
//            $table->timestamp('close_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('agent_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
