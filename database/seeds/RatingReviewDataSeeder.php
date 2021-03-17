<?php

use Illuminate\Database\Seeder;

class RatingReviewDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feedBackData = [
            [
                'name' => 'Definitely yes',
                'type' => '0',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Maybe',
                'type' => '0',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Definitely no',
                'type' => '0',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Very disappointed',
                'type' => '1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Somewhat disappointed',
                'type' => '1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Not disappointed',
                'type' => '1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];
        DB::table('private_review_categories')->insert($feedBackData);
    }
}
