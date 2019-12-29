<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->softDeletes();
        });

        Schema::create('help_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->softDeletes();
        });

        Schema::create('help_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->softDeletes();
        });

        Schema::create('help_categories_users', function (Blueprint $table) {

            $table->integer('category_id')
                ->unsigned();
            $table->integer('user_id')
                ->unsigned();


            $table->foreign('category_id')
                ->references('id')
                ->on('help_categories')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });

        Schema::create('help_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->longText('content')
                ->nullable();

            $table->integer('status_id')
                ->unsigned();
            $table->integer('priority_id')
                ->unsigned();
            $table->integer('user_id')
                ->unsigned();
            $table->integer('agent_id')
                ->unsigned();
            $table->integer('category_id')
                ->unsigned();

            $table->timestamp('close_at')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('status_id')
                ->references('id')
                ->on('help_statuses')
                ->onDelete('cascade')
                ->onupdate('cascade');
            $table->foreign('priority_id')
                ->references('id')
                ->on('help_priorities')
                ->onDelete('cascade')
                ->onupdate('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');
            $table->foreign('agent_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onupdate('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('help_categories')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });

        Schema::create('help_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content')
                ->nullable();
            $table->longText('html')
                ->nullable();

            $table->integer('user_id')
                ->unsigned();
            $table->integer('ticket_id')
                ->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('help_audits', function (Blueprint $table) {
            $table->increments('id');
            $table->text('operation');

            $table->integer('user_id')
                ->unsigned();
            $table->integer('ticket_id')
                ->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help_tickets');
        Schema::dropIfExists('help_audits');
        Schema::dropIfExists('help_comments');
        Schema::dropIfExists('help_categories_users');
        Schema::dropIfExists('help_categories');
        Schema::dropIfExists('help_priorities');
        Schema::dropIfExists('help_statuses');
    }
}
