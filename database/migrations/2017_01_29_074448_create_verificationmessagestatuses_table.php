<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationmessagestatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificationmessagestatuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام وضعیت');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش وضعیت');
            $table->longText('description')->nullable()->comment('توضیح درباره وضعیت');
            $table->integer('order')->default(0)->comment('ترتیب نمایش وضعیت - در صورت نیاز به استفاده');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `verificationmessagestatuses` comment 'وضعیت های مختلف پیام تایید حساب کاربری'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verificationmessagestatuses');
    }
}
