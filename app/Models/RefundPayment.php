<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundPayment extends Model
{
    protected $fillable = ['unique_id','payment_amount','reject_date'];
}
