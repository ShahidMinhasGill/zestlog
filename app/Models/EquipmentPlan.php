<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentPlan extends Model
{
    protected $table = 'equipment_plan';
    protected $fillable = ['plan_id','equipment_id'];
}
