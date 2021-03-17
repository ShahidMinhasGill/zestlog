<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyScheduleTimeSlot extends Model
{
    protected $fillable = ['my_schedule_id','time_slot_id','client_id','user_id'];
}
