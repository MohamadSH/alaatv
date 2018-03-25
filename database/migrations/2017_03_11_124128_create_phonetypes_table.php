<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phonetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش این نوع');
            $table->string('name')->nullable()->comment('نام این نوع در سیستم');
            $table->longText('description')->nullable()->comment('توضیحات این نوع');
            $table->tinyInteger('isEnable')->default(1)->comment('نوع شماره تلفن فعال است یا خیر');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `phonetypes` comment 'انواع مختلف شماره تلفن'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phonetypes');
    }
}
