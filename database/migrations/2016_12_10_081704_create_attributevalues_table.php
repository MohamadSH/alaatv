<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributevaluesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributevalues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_id')->commment('آی دی مشخص کننده صفت مورد نظر');
            $table->string('name')->nullable()->comment('نام مقدار نسبت داده شده');
            $table->longText('description')->nullable()->comment('توضیح درباره این مفدار');
            $table->tinyInteger('isDefault')->nullable()->comment('مقدار پیش فرض - در صورت وجود');
            $table->integer("order")->default(0)->comment("ترتیب مقدار");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `attributevalues` comment 'مقادیر اختصاص یافته برای یک صفت'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributevalues');
    }
}
