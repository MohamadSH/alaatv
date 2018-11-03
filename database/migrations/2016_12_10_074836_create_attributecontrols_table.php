<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAttributecontrolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributecontrols', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام کنترل صفت');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح درباره کنترل');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `attributecontrols` comment 'انواع کنترل های قابل استفاده برای صفتهای یک کالا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributecontrols');
    }
}
