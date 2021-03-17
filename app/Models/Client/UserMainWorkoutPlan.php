<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class UserMainWorkoutPlan extends Model
{
    protected $table = 'client_user_main_workout_plans';

    protected $fillable = ['user_id', 'plan_id', 'structure_id', 'week_number', 'year', 'training_plan_id', 'workout_set_type_id', 'position', 'rep_id', 'rm_id'
        ,'rep_value', 'rm_value', 'duration_id', 'duration_value', 'workout_counter', 'workout_sub_counter', 'rm_unit'];
}
