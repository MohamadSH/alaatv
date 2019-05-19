<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketPriorityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 15);
            $table->string('color', 15);
            $table->softDeletes();
        });

        Schema::table(tickets_table, function (Blueprint $table) {
//            $table->integer('priority_id')->unsigned();
//            $table->foreign('priority_id')->references('id')->on('help_priorities')->onDelete('cascade')->onUpdate('cascade');
            $table->addForeignColumn('priority_id', 'help_priorities');
        });
    }
}
