<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment('نام منبغ');
            $table->string('link')->nullable()->comment('لینک منبع');
            $table->string('photo')->nullable()->comment('عکس منبع');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `sources` comment 'سورس ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
