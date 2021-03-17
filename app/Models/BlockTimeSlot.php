<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockTimeSlot extends Model
{
    protected $fillable = ['week_id','day_id','start_time','end_time','year','unique_id'];
}
