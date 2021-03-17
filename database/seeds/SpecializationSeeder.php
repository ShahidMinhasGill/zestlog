<?php

use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            [
                'name' => 'Physical Exercise/Training',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Nutrition/Diet',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]
            , [
                'name' => 'Psychology/Mind',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'N/A',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]

        ];
        DB::table('specializations')->insert($specializations);
        $privacyList = [
            [
                'name' => 'Public',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Only followers',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]
            , [
                'name' => 'Only me',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]
        ];
        DB::table('log_privacies')->insert($privacyList);
    }
}
