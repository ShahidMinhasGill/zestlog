<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanWeekTrainingSetup extends Model
{
    protected $fillable = [ 
        'plan_id', 'day_id', 'plan_training_overview_week_id', 'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'];

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
        return $query->where(['plan_id' => $planId, 'day_id' => $dayId]);
    }
}
