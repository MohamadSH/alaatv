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
        DB::table('attributecontrols')
          ->delete();
        $data = [
            [
                'id'          => '1',
                'name'        => 'select',
                'description' => 'انتخاب یک گزینه از چند گزینه',
                'created_at'  => null,
                'updated_at'  => null,
                'deleted_at'  => null,
            ],
            [
                'id'          => '2',
                'name'        => 'groupedCheckbox',
                'description' => 'دسته ای چک باکس دارای دو حالت انتخاب شده یا انتخاب نشده',
                'created_at'  => '2017-06-04 00:05:23',
                'updated_at'  => '2017-06-04 00:05:23',
                'deleted_at'  => null,
            ],
            [
                'id'          => '3',
                'name'        => 'switch',
                'description' => 'کنترال نوع سوئیچ که در حقیقت نوعی چک باکس است با دو حالت روشن و خاموش',
                'created_at'  => '2017-11-22 14:55:08',
                'updated_at'  => '2017-11-22 14:55:08',
                'deleted_at'  => null,
            ],
        ];

        DB::table('attributecontrols')
          ->insert($data); // Query Builder
    }
}
