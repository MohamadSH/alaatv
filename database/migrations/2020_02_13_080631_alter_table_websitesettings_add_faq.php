<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableWebsitesettingsAddFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('websitesettings', function (Blueprint $table) {
            $table->longText('faq')->after('setting')->nullable()->comment('سوالات متداول سایت');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('websitesettings', function (Blueprint $table) {
            if (Schema::hasColumn('websitesettings', 'faq')) {
                $table->dropColumn('faq');
            }
        });
    }
}
