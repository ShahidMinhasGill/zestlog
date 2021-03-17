<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class PlanWeekTrainingSetup extends Model
{
    protected  $table = 'client_plan_week_training_setups';

    protected $fillable = [
        'client_plan_id', 'day_id', 'client_plan_training_overview_week_id', 'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'];

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function ScopeData($query, $data)
    {
        return $query->where($data);
    }
    public function ScopePlanSetup($query, $planId, $dayId)
    {
        return $query->where(['client_plan_id' => $planId, 'day_id' => $dayId]);
    }
}
