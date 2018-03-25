<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWebsitesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websitesettings', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('setting')->comment('ستون شامل تنظیمات سایت');
            $table->integer('version')->nullable()->comment('ستون مشخص ککنده ورژن تنظیمات');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `websitesettings` comment 'تنظیمات سایت'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websitesettings');
    }
}
