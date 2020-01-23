<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductvouchersAddProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productvouchers', function (Blueprint $table) {
            $table->text('products')->after('product_id')->nullable()->comment('محصولات ووچر');
            $table->timestamp('used_at')->after('user_id')->nullable()->comment('زمان استفاده');
            $table->unsignedInteger('contractor_id')->after('id')->nullable()->comment('آیدی شرکت استفاده کننده');

            $table->foreign('contractor_id')
                ->references('id')
                ->on('contractors')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productvouchers', function (Blueprint $table) {
            if (Schema::hasColumn('productvouchers', 'products')) {
                $table->dropColumn('products');
            }

            if (Schema::hasColumn('productvouchers', 'used_at')) {
                $table->dropColumn('used_at');
            }

            if (Schema::hasColumn('productvouchers', 'contractor_id')) {
                $table->dropForeign('productvouchers_contractor_id_foreign');
                $table->dropColumn('contractor_id');
            }
        });
    }
}
