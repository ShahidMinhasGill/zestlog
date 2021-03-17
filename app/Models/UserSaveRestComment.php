<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSaveRestComment extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'day_id', 'content'];
}
