<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentMajorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_major', function (Blueprint $table) {
            $table->unsignedInteger('assignment_id');
            $table->unsignedInteger('major_id');
            $table->primary([
                                'assignment_id',
                                'major_id',
                            ]);
            $table->timestamps();

            $table->foreign('assignment_id')
                  ->references('id')
                  ->on('assignments')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('major_id')
                  ->references('id')
                  ->on('majors')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `assignment_major` comment 'رشته هایی که یک تمرین به آن ها مربوط می شود'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_major');
    }
}
