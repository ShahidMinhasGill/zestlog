<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCoachingSession extends Model
{
    protected $fillable = ['training_program_price_setup_id', 'type', 'is_listing', 'session_length_id', 'price_changed', 'price_checked', 'rate_checked', 'price_up', 'price_down', 'rate_up', 'rate_down'];
}
