<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert training plan setups
        $setValues = ['---','1-2', '1-3', '1-4', '2-3', '2-4', '2-5','3-4','3-5','4-6'];
        $arrSet = prepareSeederData($setValues);
        DB::table('sets')->insert($arrSet);

        $repValues = ['---','1-5','6-12','8-12','8-10', '12-20'];
        $arrRep = prepareSeederData($repValues);
        DB::table('reps')->insert($arrRep);

        $durationValues = ['---','30 s','60 s', '5-10 min', '30 min', '45 min', '60 min', '90 min'];
        $arrDuration = prepareSeederData($durationValues);
        DB::table('durations')->insert($arrDuration);

        $rmValues = ['---','50-70', '70-80','75-85','85-100','B.W'];
        $arrRM = prepareSeederData($rmValues);
        DB::table('rms')->insert($arrRM);

        $tempoValues = ['---','Hold', 'Slow', '4/2/1', 'Moderate', '2/0/2','Fast', '1/1/1', 'Explosive'];
        $arrTempo = prepareSeederData($tempoValues);
        DB::table('tempos')->insert($arrTempo);

        $restValues = ['---','0-90 s', '0-60 s', '3-5 min'];
        $arrRest = prepareSeederData($restValues);
        DB::table('rests')->insert($arrRest);

        $noteValues = ['---','Optional', 'Walk or Slow Jog', 'Hold for 30 sec', 'Hold up to 60 s', 'Hold for 1-2 sec'];
        $arrNote = prepareSeederData($noteValues);
        DB::table('notes')->insert($arrNote);

        $formValues = ['---','Steady State', 'Interval'];
        $arrForm = prepareSeederData($formValues);
        DB::table('forms')->insert($arrForm);

        $stageValues = ['---','1', '2', '3'];
        $arrStage = prepareSeederData($stageValues);
        DB::table('stages')->insert($arrStage);

        $wrValues = ['---','1:3', '1:2', '1:1'];
        $arrWr = prepareSeederData($wrValues);
        DB::table('wrs')->insert($arrWr);

        $planStrutures = [
            ['name' => 'Warm-up',
                'key_value' => 'warm_up'
            ],
            ['name' => 'Main Workout',
                'key_value' => 'main_workout'
            ],
            ['name' => 'Cardio',
                'key_value' => 'cardio'
            ],
            ['name' => 'Cool-down',
                'key_value' => 'cool_down'
            ]
        ];
        DB::table('training_plan_structures')->insert($planStrutures);

        $workoutTypeSets = [
            ['name' => 'Horizontal set',
              'key_value' => 'horizontal',
              'position' => 1,
              'set_exercises' => 1
            ],
            ['name' => 'Vertical set',
              'key_value' => 'vertical',
               'position' => 2,
                'set_exercises' => 2
            ],
            ['name' => 'Superset',
              'key_value' => 'super',
               'position' => 3,
                'set_exercises' => 2
            ],
            ['name' => 'Triset',
              'key_value' => 'tri',
               'position' => 4,
                'set_exercises' => 3
            ],
            ['name' => 'Dropset',
              'key_value' => 'drop',
               'position' => 5,
                'set_exercises' => 1
            ],
            ['name' => 'Pyramid set',
              'key_value' => 'pyramid',
               'position' => 6,
                'set_exercises' => 1
            ],
            ['name' => 'Circuit',
              'key_value' => 'circuit',
               'position' => 7,
                'set_exercises' => 4
            ]
        ];
        DB::table('workout_type_sets')->insert($workoutTypeSets);

        $goals = [
            [
                'name' => 'Improved general health & fitness',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Reduced bodyfat % (fat loss)',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Increased muscle mass',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Improved sport performance',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];
        DB::table('goals')->insert($goals);

        $training_days = [
            [
                'name' => '1',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '2',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '3',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '4',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '5',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '6',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '7',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];

        DB::table('training_days')->insert($training_days);

        $training_ages = [
            [
                'name' => 'New to training and lifting weight',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Less than 6 months',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '6 months to 2 years',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'More than 2 years',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];
        DB::table('training_ages')->insert($training_ages);

        $age_categories = [
            [
                'name' => 'Below 20',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '20 - 29',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '30 - 39',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '40 - 49',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '50 - 59',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '60 & Above',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];
        DB::table('age_categories')->insert($age_categories);

        $days = [ 
            [
                'name' => 'Monday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Tuesday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Wednesday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Thursday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Friday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Saturday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Sunday',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];

        DB::table('days')->insert($days);

        $dayPlans = [ 
            [
                'name' => 'Training',
                'key_value' => 'training',
                'meta_data' => NULL,
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Active Rest',
                'key_value' => 'active_rest',
                'meta_data' => NULL,
                'meta_description' => '“Active rest" means today is not a training day, however, you are recommended to stay active by doing activities such as <br/>
                    -Outdoor walking or jogging
                    -Outdoor biking
                    -Hiking
                    -Swimming
                    -Any other similar activities',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Rest',
                'key_value' => 'rest',
                'meta_data' => NULL,
                'meta_description' => '“Rest” means today is not a training day, and for the recovery purpose, you may not train today.',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];

        DB::table('day_plans')->insert($dayPlans);
    }
}
