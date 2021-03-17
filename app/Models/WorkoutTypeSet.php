<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutTypeSet extends Model
{
   protected $fillable = ['name', 'key_value', 'position'];
}
