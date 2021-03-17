<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientPlanTrainingComment extends Model
{
    protected $fillable = ['client_plan_id', 'day_id', 'comment'];
}
