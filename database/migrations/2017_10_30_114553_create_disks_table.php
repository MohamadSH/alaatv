<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("disktype_id")
                  ->nullable()
                  ->comment("آی دی مشخص کننده نوع دیسک");
            $table->string('name')
                  ->unique()
                  ->comment("نام دیسک");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('disktype_id')
                  ->references('id')
                  ->on('disktypes')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `disks` comment 'جدول دیسک های فایل ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disks', function (Blueprint $table) {
            if (Schema::hasColumn('disks', 'disktype_id')) {
                $table->dropForeign('disks_disktype_id_foreign');
            }
        });
        Schema::dropIfExists('disks');
    }
}
