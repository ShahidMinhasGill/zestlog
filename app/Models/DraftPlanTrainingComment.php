<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftPlanTrainingComment extends Model
{
    protected $fillable = ['plan_id', 'day_id', 'comment'];
}
