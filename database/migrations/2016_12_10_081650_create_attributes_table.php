<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("attributecontrol_id")->nullable()->comment("آی دی مشخص کننده کنترل قابل استفاده برای صفت") ;
            $table->string('name')->nullable()->comment('نام صفت');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش') ;
            $table->longText('description')->nullable()->comment('توضیح درباره صفت');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('attributecontrol_id')
                ->references('id')
                ->on('attributecontrols')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
        DB::statement("ALTER TABLE `attributes` comment 'صفت های موجود برای یک کالا'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
