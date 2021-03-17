<?php

use Illuminate\Database\Seeder;

class AssessmentsQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionsFirst = [
            [
                'title' => 'Physical Activity Readiness Questionnaire (PAR-Q)',
                'parent_id' => null,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Has your doctor ever said that you have a heart condition and you should only perform physical activity recommended by a doctor?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you feel painin your chest when you perform physical activity?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'In the past month, have you had chest pain when you are not performing any physical activity?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you often lose your balance because of severe dizziness?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you have a bone or joint problem that could be made worse by a change in your physical activity?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Is your doctor currently prescribing any medication for your blood pressure or for a heart condition?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you know of any other reason why you should not engage in physical activity?',
                'parent_id' => 1,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
        ];
        DB::table('assessments_questions')->insert($questionsFirst);

        $questionsSecond = [
            [
                'title' => 'Medical Questionnaire',
                'parent_id' => null,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Have you ever had any injuries (ankle, knee, hip, back, shoulder, etc.)? If yes, please explain.',
                'parent_id' => 9,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Have you ever had any surgeries? If yes, please explain.',
                'parent_id' => 9,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Has a medical doctor ever diagnosed you with a chronic disease, such as heart disease, artery disease, hypertension (high blood pressure), high cholesterol or diabetes? If yes, please explain.',
                'parent_id' => 9,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you currently have a disability? If yes, please explain.',
                'parent_id' => 9,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Are you currently taking any medication? If yes, please list.',
                'parent_id' => 9,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];

        DB::table('assessments_questions')->insert($questionsSecond);

        $questionsThird = [
            [
                'title' => 'Occupational & Lifestyle Questionnaire',
                'parent_id' => null,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'What is your current occupation?',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Does your occupation require long hours of sitting?',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Does your occupation require long hours of repetitive movements?',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Does your occupation require you to wear shoes with high heels?',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Does your occupation cause you anxiety (mental stress)?',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you participate in any leisure activities such as golf, tennis, skiing, swimming, etc.? If yes, please list them.',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'title' => 'Do you have any hobbies such as reading, watching TV, gardening, working on cars, exploring the Internet, etc.)? If yes, please list them.',
                'parent_id' => 17,
                'status' => 1,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]

        ];
        DB::table('assessments_questions')->insert($questionsThird);

        

    }
}
