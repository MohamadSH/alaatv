<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropTablesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_attributegroup', function ($table) {
            if (Schema::hasColumn('attribute_attributegroup', 'attributetype_id'))
            {
                $table->dropForeign('attribute_attributegroup_attributetype_id_foreign');
                $table->dropColumn('attributetype_id');
            }
        });
        Schema::dropIfExists('educationalcontent_grade');
        Schema::dropIfExists('educationalcontent_major');
        Schema::dropIfExists('educationalcontent_contenttype');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
