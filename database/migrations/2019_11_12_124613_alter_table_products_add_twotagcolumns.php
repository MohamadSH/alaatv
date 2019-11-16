<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductsAddTwotagcolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('recommender_contents')->nullable()->after('tags')->comment('کانتنت های پیشنهاد دهده این محصول');
            $table->text('sample_contents')->nullable()->after('recommender_contents')->comment('کانتنت های نمونه این محصول');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'recommender_contents')) {
                $table->dropColumn('recommender_contents');
            }

            if (Schema::hasColumn('products', 'sample_contents')) {
                $table->dropColumn('sample_contents');
            }
        });
    }
}
