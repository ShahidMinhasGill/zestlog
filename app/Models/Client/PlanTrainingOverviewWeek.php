<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class PlanTrainingOverviewWeek extends Model
{
   protected $table = 'client_plan_training_overview_weeks';
    protected $fillable = [
        'client_plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3', 'meta_data', 'meta_description'
    ];

    /*
    |--------------------------------------------------------------------------
    | Eloquent Relations
    |--------------------------------------------------------------------------
    */
    public function plan()
    {
        return $this->BelongsTo(Plan::class);
    }
    public function day()
    {
        return $this->BelongsTo(Day::class)->select(['id', 'name']);
    }
    public function day_plan()
    {
        return $this->BelongsTo(DayPlan::class)->select(['id', 'name']);
    }
    public function body_part_fst()
    {
        return $this->BelongsTo(BodyPart::class, 'body_part_1')->select(['id', 'name']);
    }
    public function body_part_scnd()
    {
        return $this->BelongsTo(BodyPart::class, 'body_part_2')->select(['id', 'name']);
    }
    public function body_part_thrd()
    {
        return $this->BelongsTo(BodyPart::class, 'body_part_3')->select(['id', 'name']);
    }
    public function weekly_setup()
    {
        return $this->hasOne(PlanWeekTrainingSetup::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function ScopeData($query, $data)
    {
        return $query->where($data);
    }
    public function ScopePlans($query, $id)
    {
        return $query->where('client_plan_id', $id);
    }
    public function ScopePlanOverView($query, $planId, $dayId)
    {
        return $query->where(['client_plan_id' => $planId, 'day_id' => $dayId]);
    }
}
