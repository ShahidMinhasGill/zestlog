<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['id','user_id', 'notification', 'is_read','is_checked', 'notification_user_id'];
}
