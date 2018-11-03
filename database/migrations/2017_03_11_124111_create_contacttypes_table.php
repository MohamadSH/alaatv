<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContacttypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacttypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('displayName')
                  ->nullable()
                  ->comment('نام قابل نمایش نوع');
            $table->string('name')
                  ->nullable()
                  ->comment('نام این نوع در سیستم');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیحات این نوع');
            $table->tinyInteger('isEnable')
                  ->default(1)
                  ->comment('نوع دفترچه تلفن فعال است یا خیر');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `contacttypes` comment 'انواع مختلف یک رکورد دفترچه تلفن'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacttypes');
    }
}
