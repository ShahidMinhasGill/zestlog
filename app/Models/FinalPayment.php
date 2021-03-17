<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalPayment extends Model
{
    protected $fillable = ['unique_id', 'client_id','status','is_payment','user_id',
        'reference_number','counter', 'starting_date', 'end_date',
        'service_fee','service_fee_from_coach','total_service_fee',
        'total_amount','client_f_amount','Training_Program_amount',
        'Online_Coaching_amount','Personal_Training_amount','earning_week_program','earning_oc_session','earning_pt_session','f_tp_amount','f_oc_amount','f_pt_amount'];
}
