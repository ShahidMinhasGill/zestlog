<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(SpecializationSeeder::class);
        $this->call(TrainingProgramSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(LogCategoriesTableSeeder::class);
        $this->call(RatingReviewDataSeeder::class);
        $this->call(AssessmentsQuestionsTableSeeder::class);
        $this->call(TermPolicy::class);
    }
}
