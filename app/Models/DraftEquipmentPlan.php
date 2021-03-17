<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftEquipmentPlan extends Model
{
    protected $table = 'draft_equipment_plans';
    protected $fillable = ['plan_id','equipment_id'];
}
