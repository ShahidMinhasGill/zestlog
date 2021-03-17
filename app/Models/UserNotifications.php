<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    protected $fillable = ['user_id','is_coach_appointment_reminder','is_exercise_reminder','is_chat_and_call',
        'is_you_received_a_follow_request','is_your_follow_request_is_accepted','is_someone_you_may_know'];
}
