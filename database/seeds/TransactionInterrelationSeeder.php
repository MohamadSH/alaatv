<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionInterrelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactioninterraltions')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'parent-child',
                'displayName' => 'فرزند-والد',
                'description' => 'به طوری قرارداری اولی والد دومی می باشد',
            )
        );
        DB::table('transactioninterraltions')->insert($data); // Query Builder
    }
}
