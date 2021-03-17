<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tempo extends Model
{
    protected $fillable = ['value','meta_data','meta_description','client_id','order','is_customized'];
}
