<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebsitepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websitepages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')
                  ->comment("آدرس مختص این صفحه");
            $table->string('displayName')
                  ->nullable()
                  ->comment("نام قابل نمایش این صفحه");
            $table->longText('description')
                  ->nullable()
                  ->comment("توضیح درباره صفحه");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `websitepages` comment 'صفحه های سایت'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websitepages');
    }
}
