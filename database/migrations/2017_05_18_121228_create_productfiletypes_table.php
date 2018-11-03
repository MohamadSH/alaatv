<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductfiletypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productfiletypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment("نام نوع");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش نوع");
            $table->string("description")
                  ->nullable()
                  ->comment("توضیح درباره نوع فایل محصول");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `productfiletypes` comment 'انواع فایل یک محصول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productfiletypes');
    }
}
