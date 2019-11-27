<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductblocksAddUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('block_product', function (Blueprint $table) {
            $table->primary([
                'block_id',
                'product_id',
            ]);
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
        Schema::table('block_product', function (Blueprint $table) use ($conn, $dbSchemaManager) {
            if ($dbSchemaManager->listTableDetails('block_product')->hasIndex('PRIMARY')){
                $table->dropIndex('PRIMARY');
            }
        });
    }
}
