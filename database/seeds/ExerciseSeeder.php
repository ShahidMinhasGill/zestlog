<?php

use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $body_part_exercises = [
            [
                'name' => 'Neck',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Shoulder',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Chest',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Arm',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Back',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Abdomen',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Leg',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Full Body',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];
        DB::table('body_part_exercises')->insert($body_part_exercises);

        $body_parts = [
            [
                'name' => 'Full body',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Upper body',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Lower body',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Neck',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Shoulder',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Chest',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Back',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Arm',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Abdomen',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Leg',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];
        DB::table('body_parts')->insert($body_parts);

        $target_muscles = [
            [
                'name' => 'Neck',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Front Deltoid',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Mid Deltoid',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Rear Deltoid',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Total Deltoid',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Anterior Rotator Cuff',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Posterior Rotator Cuff',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Upper Chest',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Middle Chest',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Lower Chest',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Total Chest',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Biceps',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Triceps',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Forearms',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Hands',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Traps',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Middle Back',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Lats',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Lower Back',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Erector Spinae',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Abs',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Obliques',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Glutes',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Quads',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Hamstrings',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Hip Extensor',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Hip Flexors',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Hip Abductors',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],[
                'name' => 'Hip Adductors',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Hip Rotators',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Calves',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Total Leg',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Full Body',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];

        DB::table('target_muscles')->insert($target_muscles);

        $training_forms = [
            [
                'name' => 'Resistance Training',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Cardio Training',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Flexibility Training',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Balance & Stabilization Training',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Polymetric & SAQ Training',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Yoga',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Pilates',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];

        DB::table('training_forms')->insert($training_forms);

        $disciplines = [
            [
                'name' => 'Powerlifting',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Olympic Weightlifting',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Strongman',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Yoga',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Pilates',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Stretching',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'TRX',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'NA',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];
        DB::table('disciplines')->insert($disciplines);

        $levels = [
            [
                'name' => 'Beginner',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Intermidiate',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Advanced',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'NA',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];
        DB::table('levels')->insert($levels);

         $priorities = [
             [
                 'name' => 'Priority 1',
                 'meta_data' => '',
                 'meta_description' => '',
                 'created_at' => date("Y-m-d h:i:s"),
                 'updated_at' => date("Y-m-d h:i:s")
             ],
             [
                 'name' => 'Priority 2',
                 'meta_data' => '',
                 'meta_description' => '',
                 'created_at' => date("Y-m-d h:i:s"),
                 'updated_at' => date("Y-m-d h:i:s")
             ],
             [
                 'name' => 'Priority 3',
                 'meta_data' => '',
                 'meta_description' => '',
                 'created_at' => date("Y-m-d h:i:s"),
                 'updated_at' => date("Y-m-d h:i:s")
             ],
             [
                 'name' => 'NA',
                 'meta_data' => '',
                 'meta_description' => '',
                 'created_at' => date("Y-m-d h:i:s"),
                 'updated_at' => date("Y-m-d h:i:s")
             ]
         ];
            DB::table('priorities')->insert($priorities);

        $equipment = [
            [
                'name' => 'Barbell',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Dumbbell',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Cable',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Machine',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'EZ Bar',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Kettlebell',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Plate',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Landmine',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Battling Rope',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Resistance Band',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'TRX',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Suspension Ring',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Stability Ball',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Bosu Ball',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Medicine Ball',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Foam Roller',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Bodyweight',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => 'Bench',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];

        DB::table('equipment')->insert($equipment);


    }
}
