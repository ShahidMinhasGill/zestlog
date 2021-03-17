<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MySchedule extends Model
{
    protected $fillable = ['is_block_whole_week','is_block_whole_day','start_time_slot_block','end_time_slot_block','week'];
}
