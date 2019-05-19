<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->nullable();

            $table->integer('user_id')->unsigned();
            $table->integer('ticket_id')->unsigned();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
