<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام');
            $table->integer('order')->default(0)->comment('ترتیب');
            $table->boolean('enable')->default(1)->comment('فعال یا غیرفعال');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `sections` comment 'جدول سکشن بندی کانتنت ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
