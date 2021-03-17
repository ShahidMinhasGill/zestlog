<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftPlanWeekTrainingSetupPosition extends Model
{
    protected $fillable = ['plan_week_training_setup_id', 'workout_type_set_id', 'workout_main_counter', 'position', 'exercise_set','is_delete','is_edit'];

    /**
     * this is used to get training plan setup data
     *
     * @param $params
     * @return mixed
     */
    public static function getTrainingSetupData($params)
    {
        return DraftPlanWeekTrainingSetupPosition::select('draft_plan_week_training_setup_positions.id',
            'draft_plan_week_training_setup_positions.plan_week_training_setup_id',
            'draft_plan_week_training_setup_positions.workout_main_counter',
            'draft_plan_week_training_setup_positions.workout_type_set_id',
            'key_value',
            'workout_main_counter',
            'draft_plan_week_training_setup_positions.position'
            , 'draft_plan_week_training_setup_positions.exercise_set')
            ->join('workout_type_sets as wts', 'wts.id', '=', 'workout_type_set_id')
            ->join('draft_plan_week_training_setups as pwts', 'pwts.id', '=', 'draft_plan_week_training_setup_positions.plan_week_training_setup_id')
            ->where('plan_week_training_setup_id', '=', $params['id'])
            ->orderBy('draft_plan_week_training_setup_positions.position', 'asc')
            ->get();
    }
}
