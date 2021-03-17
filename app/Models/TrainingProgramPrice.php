<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgramPrice extends Model
{
    protected $fillable = ['training_program_price_setup_id','training_plan_id','final_price_1','final_price_2','final_price_3','final_price_4',
        'final_price_5','final_price_6','final_price_7','type'];
}
