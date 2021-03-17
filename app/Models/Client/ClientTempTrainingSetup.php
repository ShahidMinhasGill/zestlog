<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientTempTrainingSetup extends Model
{
    protected $fillable = ['client_plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'];
}
