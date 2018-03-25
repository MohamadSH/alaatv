<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAttributeAttributegroupAddDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_attributegroup', function (Blueprint $table) {
            $table->string('description')->nullable()->comment("توضیح قابل نمایش برای کاربر در سایت")->after("order");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_attributegroup', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
