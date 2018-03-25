<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributecontrols')->delete();
        $data = array(
            array(
                'id' => '1',
                'name' => 'select',
                'description' => 'انتخاب یک گزینه از چند گزینه',
            ),
            array(
                'id' => '2',
                'name' => 'groupedCheckbox',
                'description' => 'دسته ای چک باکس دارای دو حالت انتخاب شده یا انتخاب نشده',
            ),
            array(
                'id' => '3',
                'name' => 'multiSelect',
                'description' => 'انتخاب چند گزینه از چند گزینه',
            ),
        );

        DB::table('attributecontrols')->insert($data); // Query Builder
    }
}
