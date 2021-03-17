<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $fillable = [ 'name', 'meta_data', 'meta_description'];
}
