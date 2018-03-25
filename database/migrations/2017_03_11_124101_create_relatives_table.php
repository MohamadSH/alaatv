<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام رکورد');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش رکورد');
            $table->longText('description')->nullable()->comment('توضیح رکورد');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `relatives` comment 'نسبت های خانوادگی'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relatives');
    }
}
