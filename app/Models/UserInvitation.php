<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    protected $fillable = ['user_id','invited_user_id','invitation_code','invited_code'];
}
