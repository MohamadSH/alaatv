<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlinetransactiongatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlinetransactiongateways', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام سیستمی درگاه');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش درگاه');
            $table->longText('description')->nullable()->comment('توضیح درباره درگاه');
            $table->string('merchantNumber')->nullable()->comment('شماره مرچنت درگاه');
            $table->tinyInteger('enable')->default(1)->comment('فعال بودن یا نبودن درگاه');
            $table->integer('order')->default(0)->comment('ترتیب - در صورت نیاز به استفاده');
            $table->unsignedInteger('bank_id')->nullable()->comment('آیدی مشخص کننده بانک درگاه');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `onlinetransactiongateways` comment 'لیست درگاه های بانکی'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onlinetransactiongateways');
    }
}
