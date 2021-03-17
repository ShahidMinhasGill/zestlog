<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientPlanWeekTrainingSetupPosition extends Model
{
    protected $fillable = ['client_plan_week_training_setup_id', 'workout_type_set_id', 'workout_main_counter', 'position', 'exercise_set'];

    /**
     * this is used to get training plan setup data
     *
     * @param $params
     * @return mixed
     */
    public static function getTrainingSetupData($params)
    {
        return ClientPlanWeekTrainingSetupPosition::select('client_plan_week_training_setup_positions.id',
            'client_plan_week_training_setup_positions.client_plan_week_training_setup_id',
            'client_plan_week_training_setup_positions.workout_main_counter',
            'client_plan_week_training_setup_positions.workout_type_set_id','key_value',
            'workout_main_counter', 'client_plan_week_training_setup_positions.position'
            , 'client_plan_week_training_setup_positions.exercise_set')
            ->join('workout_type_sets as wts', 'wts.id', '=', 'workout_type_set_id')
            ->join('client_plan_week_training_setups as pwts', 'pwts.id', '=', 'client_plan_week_training_setup_positions.client_plan_week_training_setup_id')
            ->where('client_plan_week_training_setup_id', '=', $params['id'])->orderBy('client_plan_week_training_setup_positions.position', 'asc')->get();
    }

}
