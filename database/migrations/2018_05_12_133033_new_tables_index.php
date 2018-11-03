<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewTablesIndex extends Migration
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

        Schema::table('websitepages', function (Blueprint $table) use ($conn, $dbSchemaManager) {
            if (!$dbSchemaManager->listTableDetails('websitepages')
                                 ->hasIndex('websitepages_url_deleted_at_index'))
                $table->index([
                                  'url',
                                  'deleted_at',
                              ]);

        });

        Schema::table('grades', function (Blueprint $table) use ($conn, $dbSchemaManager) {
            if (!$dbSchemaManager->listTableDetails('grades')
                                 ->hasIndex('grades_name_index'))
                $table->index('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $conn = Schema::getConnection();
        $dbSchemaManager = $conn->getDoctrineSchemaManager();
        Schema::table('websitepages', function (Blueprint $table) use ($conn, $dbSchemaManager) {
            if ($dbSchemaManager->listTableDetails('websitepages')
                                ->hasIndex('websitepages_url_deleted_at_index'))
                $table->dropIndex('websitepages_url_deleted_at_index');
        });
        Schema::table('grades', function (Blueprint $table) use ($conn, $dbSchemaManager) {
            if (!$dbSchemaManager->listTableDetails('grades')
                                 ->hasIndex('grades_name_index'))
                $table->dropIndex('grades_name_index');

        });
    }
}
