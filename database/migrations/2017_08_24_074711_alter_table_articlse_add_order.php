<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableArticlseAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('order')->default(0)->comment('ترتیب مقاله')->after("articlecategory_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(' articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'order')) {
                $table->dropColumn('order');
            }
        });
    }
}
