<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableChildproductParentproductAddDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('childproduct_parentproduct', function (Blueprint $table) {
            $table->tinyInteger('isDefault')->default(0)->comment('فرزند پیش فرض بودن یا نبودن')->after("child_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('childproduct_parentproduct', function (Blueprint $table) {
            if (Schema::hasColumn('childproduct_parentproduct', 'isDefault')) {
                $table->dropColumn('isDefault');
            }
        });
    }
}
