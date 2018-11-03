<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMajorMajorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('major_major', function (Blueprint $table) {
            $table->unsignedInteger('major1_id');
            $table->unsignedInteger('major2_id');
            $table->unsignedInteger('relationtype_id')
                  ->comment("نوع رابطه ی این دو رشته با یکدیگر");
            $table->string('majorCode')
                  ->nullable()
                  ->comment("کد ردیف رشته در دفترچه");
            $table->primary([
                                'major1_id',
                                'major2_id',
                                'relationtype_id',
                            ]);

            $table->foreign('major1_id')
                  ->references('id')
                  ->on('majors')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('major2_id')
                  ->references('id')
                  ->on('majors')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('relationtype_id')
                  ->references('id')
                  ->on('majorinterrelationtypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `major_major` comment 'رابطه یک رشته با رشته دیگر به همراه نوع رابطه'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('major_major');
    }
}
