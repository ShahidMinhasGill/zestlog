<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $fillable = ['user_id','service_id','pricing_discount_data','days_id',
        'change_training_plan_id','starting_date','week_id','training_plan_id','session_length','training_session_location_id',
        'training_session_location','unique_id', 'end_date','program_price','first_name',
        'last_name','full_name','user_name','middle_name','is_confirmed'];
}
