<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransactioninterraltionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactioninterraltions', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")
                  ->nullable()
                  ->comment("نام");
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش");
            $table->string("description")
                  ->nullable()
                  ->comment("توضیح");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `transactioninterraltions` comment 'جدول رابطه های مختلف دو نوع محتوا با یکدیگر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactioninterraltions');
    }
}
