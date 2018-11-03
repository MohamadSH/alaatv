<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiskFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disk_file', function (Blueprint $table) {
            $table->unsignedInteger("file_id");
            $table->unsignedInteger("disk_id");
            $table->integer("priority")
                  ->default(0)
                  ->comment("اولویت فایل در دیسک");
            $table->primary([
                                'file_id',
                                'disk_id',
                            ]);
            $table->timestamps();

            $table->foreign('file_id')
                  ->references('id')
                  ->on('files')
                  ->onDelete('cascade')
                  ->onupdate('cascade');

            $table->foreign('disk_id')
                  ->references('id')
                  ->on('disks')
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
        Schema::dropIfExists('disk_file');
    }
}
