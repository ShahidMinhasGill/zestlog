<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayPlan extends Model
{
    protected $fillable = [ 'name', 'meta_data', 'meta_description'];
}
