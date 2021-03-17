<?php

use Illuminate\Database\Seeder;

class TrainingProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Training Program',
                'key_pair' => 'training_program',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Diet Program',
                'key_pair' => 'diet_program',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Online Coaching',
                'key_pair' => 'online_coaching',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Personal Training',
                'key_pair' => 'personal_training',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],

        ];

        DB::table('services')->insert($services);


        $training_plan_days = [
            [
                'name' => '1 day per week',
                'type' => 1,
                'days_value'=> 1,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '2 days per week',
                'type' => 1,
                'days_value'=> 2,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '3 days per week',
                'type' => 1,
                'days_value'=> 3,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '4 days per week',
                'type' => 1,
                'days_value'=> 4,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '5 days per week',
                'type' => 1,
                'days_value'=> 5,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '6 days per week',
                'type' => 1,
                'days_value'=> 6,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '7 days per week',
                'type' => 1,
                'days_value'=> 7,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],

        ];

        DB::table('training_plans')->insert($training_plan_days);

        $training_plan_days_diet = [
            [
                'name' => '7 diet plans (7 days) per week',
                'type' => 2,
                'days_value'=> 7,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];

        DB::table('training_plans')->insert($training_plan_days_diet);

        $week_program = [
            [
                'name' => '1-week program',
                'meta_data' => 1,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '4-week program',
                'meta_data' => 4,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '8-week program',
                'meta_data' => 8,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '12-week program',
                'meta_data' => 12,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '24-week program',
                'meta_data' => 24,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '48-week program',
                'meta_data' => 48,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],

        ];

        DB::table('week_programs')->insert($week_program);

        $training_plan_days = [
            [
                'name' => '1 session every 4 weeks',
                'type' => 3,
                'days_value'=> 0.25,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '1 session every 2 weeks',
                'type' => 3,
                'days_value'=>0.5,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '1 session per week',
                'type' => 3,
                'days_value'=> 1,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '2 sessions per week',
                'type' => 3,
                'days_value'=> 2,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '3 sessions per week',
                'type' => 3,
                'days_value'=> 3,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '4 sessions per week',
                'type' => 3,
                'days_value'=> 4,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '5 sessions per week',
                'type' => 3,
                'days_value'=> 5,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '6 sessions per week',
                'type' => 3,
                'days_value'=> 6,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '7 sessions per week',
                'type' => 3,
                'days_value'=> 7,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],

        ];

        DB::table('training_plans')->insert($training_plan_days);

        $training_plan_days = [
            [
                'name' => '1 PT session every 4 weeks',
                'type' => 4,
                'days_value'=> 0.25,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '1 PT session every 2 weeks',
                'type' => 4,
                'days_value'=> 0.5,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '1 PT session per week',
                'type' => 4,
                'days_value'=> 1,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '2 PT sessions per week',
                'type' => 4,
                'days_value'=> 2,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '3 PT sessions per week',
                'type' => 4,
                'days_value'=> 3,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '4 PT sessions per week',
                'type' => 4,
                'days_value'=> 4,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '5 PT sessions per week',
                'type' => 4,
                'days_value'=> 5,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '6 PT sessions per week',
                'type' => 4,
                'days_value'=> 6,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '7 PT sessions per week',
                'type' => 4,
                'days_value'=> 7,
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],

        ];

        DB::table('training_plans')->insert($training_plan_days);
        $sessions = ['15 min', '30 min', '45 min', '60 min'];
        $arrSessions = prepareSeederData($sessions, 'value', false);
        DB::table('training_coaching_session_lengths')->insert($arrSessions);
        $data = ['30 min', '45 min', '60 min'];
        $arrSet = [];
        $keyVal = 'value';
        foreach ($data as $key => $row) {
            $arrSet[$key][$keyVal] = $row;
            $arrSet[$key]['type'] = 4;
            $arrSet[$key]['created_at'] = date("Y-m-d h:i:s");
            $arrSet[$key]['updated_at'] = date("Y-m-d h:i:s");
        }

        DB::table('training_coaching_session_lengths')->insert($arrSet);

        $changeTrainingPlans = [
            [
                'name' => 'No change',
                'meta_data' => 1,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Every 4 weeks',
                'meta_data' => 4,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Every 8 weeks',
                'meta_data' => 8,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Every 12 weeks',
                'meta_data' => 12,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];

        DB::table('change_training_plans')->insert($changeTrainingPlans);


        $repeatProgramePurchase = [
            [
                'name' => '1 New Training Program',
                'meta_data' => 1,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '2 New Training Programs',
                'meta_data' => 2,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '3 New Training Programs',
                'meta_data' => 3,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '4 New Training Programs',
                'meta_data' => 4,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '6 New Training Programs',
                'meta_data' => 6,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '12 New Training Programs',
                'meta_data' => 12,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];

        DB::table('repeat_program_purchases')->insert($repeatProgramePurchase);
    }
}
