<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 15);
            $table->string('color', 15);
            $table->softDeletes();
        });
        
        Schema::create('help_categories_users', function (Blueprint $table) {
            $table->addForeignColumn('category_id', 'help_categories');
            $table->addForeignColumn('user_id', 'users');
        });

        Schema::table(tickets_table, function (Blueprint $table) {
            $table->addForeignColumn('category_id', 'help_categories');
        });
    }
}

//        Schema::table('help_ticket', function (Blueprint $table) {
//            $table->integer('category_id')->unsigned();
//            $table->foreign('category_id')->references('id')->on('help_categories')->onDelete('cascade')->onUpdate('cascade');
//        });
//        Schema::create('help_categories_users', function (Blueprint $table) {
//            $table->integer('category_id')->unsigned();
//            $table->foreign('category_id')->references('id')->on('help_categories')->onDelete('cascade')->onupdate('cascade');
//            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onupdate('cascade');
//        });

