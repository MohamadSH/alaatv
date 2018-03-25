<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoupontypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupontypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش این نوع');
            $table->string('name')->nullable()->comment('نام این نوع در سیستم');
            $table->longText('description')->nullable()->comment('توضیحات این نوع');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `coupontypes` comment 'انواع مختلف کپن تخفیف'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupontypes');
    }
}
