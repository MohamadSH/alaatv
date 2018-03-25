<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationMajorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_major', function (Blueprint $table) {
            $table->unsignedInteger('consultation_id');
            $table->unsignedInteger('major_id');
            $table->primary(['consultation_id','major_id']);
            $table->timestamps();

            $table->foreign('consultation_id')
                ->references('id')
                ->on('consultations')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('major_id')
                ->references('id')
                ->on('majors')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `consultation_major` comment 'رشته هایی که یک مشاوره به آن ها مربوط می شود'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultation_major');
    }
}
