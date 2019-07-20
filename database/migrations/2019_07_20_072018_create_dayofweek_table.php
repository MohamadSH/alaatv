<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayofweekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dayofweek', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام روز');
            $table->string('display_name')->nullable()->comment('نام قابل نمایش روز');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `dayofweek` comment 'جدول روزهای هفته'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dayofweek');
    }
}
