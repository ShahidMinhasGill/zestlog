<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgramPriceSetup extends Model
{
    protected $fillable = ['user_id', 'type', 'base_price', 'is_auto_calculate_discount',
        'length_online_coaching_session', 'group_online_coaching', 'pt_session_location',
        'length_pt_session', 'group_personal_training','repeat_percentage_value',
        'is_use_default_week_repeat','is_use_default_length_program_booking','is_use_default_repeat_purchase_booking'];
    /**
     * Get the Prices for the Training Program Setup.
     */
    public function prices()
    {
        return $this->hasMany(PricingDiscount::class);
    }
}
