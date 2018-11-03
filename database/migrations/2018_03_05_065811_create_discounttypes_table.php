<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscounttypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounttypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment("نام");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش");
            $table->string("description")
                  ->nullable()
                  ->comment("توضیح کوتاه");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounttypes');
    }
}
