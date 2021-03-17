<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmedAmount extends Model
{
    protected $fillable = ['client_id','amount','confirmed_date','is_confirmed',
        'payout_month','client_week_plan_id','booking_id','is_paid_to_client','payout_date'];
}
