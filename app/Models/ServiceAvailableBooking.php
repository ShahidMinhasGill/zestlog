<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAvailableBooking extends Model
{
    protected $fillable = ['user_id','is_checked','service_id','currency_id'];
}
