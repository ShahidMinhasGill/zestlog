<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RattingFreelanceAndZestlog extends Model
{
    protected $fillable = ['client_id','user_id','unique_id','star_coach_and_program',
        'experience_about_coach','experience_about_coach','star_zestlog','experience_zestlog'];
}
