<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductDropBlockid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'block_id')) {
                $table->dropForeign('products_block_id_foreign');
                $table->dropColumn('block_id');
            }
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
            $table->unsignedInteger('block_id')->nullable()->after('grand_id')->comment('بلاک مرتبط با این محصول');

            $table->foreign('block_id')
                ->references('id')
                ->on('blocks')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
    }
}
