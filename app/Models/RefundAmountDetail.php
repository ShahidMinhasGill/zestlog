<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundAmountDetail extends Model
{
    protected $fillable = ['unique_id','strip_id','object','amount','balance_transaction',
        'charge','created','currency','metadata','payment_intent','reason',
        'receipt_number','status','transfer_reversal'];
}
