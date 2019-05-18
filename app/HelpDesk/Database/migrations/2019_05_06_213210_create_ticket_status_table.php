<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketStatusTable extends Migration
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
            $table->string('name', 15);
            $table->string('color', 15);
            $table->softDeletes();
        });

        Schema::table(tickets_table, function (Blueprint $table) {
//            $table->integer('status_id')->unsigned();
//            $table->foreign('status_id')->references('id')->on('help_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->addForeignColumn('status_id', 'help_statuses');
        });
    }
}
