<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducttypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producttypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش این نوع');
            $table->string('name')->nullable()->comment('نام این نوع در سیستم');
            $table->longText('description')->nullable()->comment('توضیحات این نوع');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `producttypes` comment 'انواع مختلف محصول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producttypes');
    }
}
