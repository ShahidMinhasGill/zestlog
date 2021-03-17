<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadProgramData extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'week_number', 'year', 'plan_drag_drop_structures', 'plan_training_overview_weeks', 'download_program_data', 'training_plan_structure', 'plan_drag_drop_structures_straight'];
}
