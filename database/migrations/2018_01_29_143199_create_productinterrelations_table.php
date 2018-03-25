<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductinterrelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productinterrelations', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->comment("نام");
            $table->string("displayName")->nullable()->comment("نام قابل نمایش");
            $table->string("description")->nullable()->comment("توضیح");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `productinterrelations` comment 'جدول انواع رابطه های دو محصول با یکدیگر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productinterrelations');
    }
}
