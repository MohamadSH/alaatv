<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMajortypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majortypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام رشته');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش رشته');
            $table->string("description")->nullable()->comment("توضیج درباره نوع رشته");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `majortypes` comment 'نوع رشته'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majortypes');
    }
}
