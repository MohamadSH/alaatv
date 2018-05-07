<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexOnTablesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $conn = Schema::getConnection();
        $dbSchemaManager = $conn->getDoctrineSchemaManager();


        Schema::table('products', function(Blueprint $table) use($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('products')->hasIndex('products_order_index'))
                $table->index('order');
        });
        Schema::table('educationalcontents', function(Blueprint $table) use($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('educationalcontents')->hasIndex('educationalcontents_created_at_index'))
                $table->index('created_at');
        });
        Schema::table('contentset_educationalcontent', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('contentset_educationalcontent')->hasIndex('contentset_educationalcontent_order_index'))
                $table->index('order');
        });
        Schema::table('contentsets', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('contentsets')->hasIndex('contentsets_created_at_index'))
                $table->index('created_at');
        });
        Schema::table('attributevalues', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('attributevalues')->hasIndex('attributevalues_order_index'))
                $table->index('order');
        });
        Schema::table('attribute_attributegroup', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('attribute_attributegroup')->hasIndex('attribute_attributegroup_order_index'))
                $table->index('order');
        });
        Schema::table('attributegroups', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('attributegroups')->hasIndex('attributegroups_order_index'))
                $table->index('order');
        });
        Schema::table('disk_file', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if (! $dbSchemaManager->listTableDetails('disk_file')->hasIndex('disk_file_priority_index'))
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //dropIndex

        $conn = Schema::getConnection();
        $dbSchemaManager = $conn->getDoctrineSchemaManager();


        Schema::table('products', function(Blueprint $table) use($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('products')->hasIndex('products_order_index'))
                $table->dropIndex('products_order_index');
        });
        Schema::table('educationalcontents', function(Blueprint $table) use($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('educationalcontents')->hasIndex('educationalcontents_created_at_index'))
                $table->dropIndex('educationalcontents_created_at_index');
        });
        Schema::table('contentset_educationalcontent', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('contentset_educationalcontent')->hasIndex('contentset_educationalcontent_order_index'))
                $table->dropIndex('contentset_educationalcontent_order_index');
        });
        Schema::table('contentsets', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('contentsets')->hasIndex('contentsets_created_at_index'))
                $table->dropIndex('contentsets_created_at_index');
        });
        Schema::table('attributevalues', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('attributevalues')->hasIndex('attributevalues_order_index'))
                $table->dropIndex('attributevalues_order_index');
        });
        Schema::table('attribute_attributegroup', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('attribute_attributegroup')->hasIndex('attribute_attributegroup_order_index'))
                $table->dropIndex('attribute_attributegroup_order_index');
        });
        Schema::table('attributegroups', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('attributegroups')->hasIndex('attributegroups_order_index'))
                $table->dropIndex('attributegroups_order_index');
        });
        Schema::table('disk_file', function(Blueprint $table) use ($conn,$dbSchemaManager)
        {
            if ($dbSchemaManager->listTableDetails('disk_file')->hasIndex('disk_file_priority_index'))
                $table->dropIndex('disk_file_priority_index');
        });
    }
}
