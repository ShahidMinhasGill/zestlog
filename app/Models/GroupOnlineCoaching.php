<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  GroupOnlineCoaching extends Model
{
    protected $fillable = ['training_program_price_setup_id', 'type', 'is_listing', 'participant_count', 'price_changed', 'price_checked', 'rate_checked', 'price_up', 'price_down', 'rate_up', 'rate_down'];
}
