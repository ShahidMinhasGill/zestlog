<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftTempTrainingSetup extends Model
{
    protected $fillable = ['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position','is_delete','is_edit'];

}
