<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfterloginformControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afterloginformcontrols', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->comments("نام کنترل");
            $table->string("displayName")->nullable()->comments("نام قابل نمایش کنترل");
            $table->tinyInteger("enable")->default(1)->comments("مشخص کننده فعال یا غیر فعال بودن کنترل");
            $table->integer("order")->default(0)->comments("ترتیب کنترل");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `afterloginformcontrols` comment 'اجزای(کنترلرهای) فرم تکمیل اطلاعات بعد از لاگین '");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('afterloginformcontrols');
    }
}
