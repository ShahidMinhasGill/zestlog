<?php

use Illuminate\Database\Seeder;

class LogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $log_categories = [
            [
                'name' => 'Fitness Motivation',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Fitness Learning/Useful Info',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Fitness Funny',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Others',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];

        DB::table('log_categories')->insert($log_categories);
    }
}
