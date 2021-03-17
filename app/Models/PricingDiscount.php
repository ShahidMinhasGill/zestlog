<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingDiscount extends Model
{
    protected $fillable = ['training_program_price_setup_id','type','discount','is_checked','discount_type','day_week_id','training_plan_id'];

    /**
     * Get the Training Program that owns the Discount Prices.
     */
    public function TrainingProgram()
    {
        return $this->belongsTo(TrainingProgramPriceSetup::class);
    }

    public function getServicesDetail($params)
    {

    }
}
