<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepeatProgramPurchaseBooking extends Model
{
    protected $fillable = ['user_id', 'training_program_price_setup_id', 'type',
        'discount_1', 'discount_2', 'discount_3', 'discount_4', 'discount_5', 'discount_6'];
}
