<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBloodtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloodtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->unique()
                  ->comment("نام");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `bloodtypes` comment 'جدول گروه خون ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloodtypes');
    }
}
