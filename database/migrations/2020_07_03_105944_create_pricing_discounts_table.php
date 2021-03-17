<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('training_program_price_setup_id')->nullable();
            $table->bigInteger('training_plan_id')->nullable();
            $table->tinyInteger('type')->default(1)->comment='1=training_program,2=diet_program,3=online_coaching,4=personal_training';
            $table->decimal('discount')->nullable();
            $table->tinyInteger('is_checked')->default(1)->comment='0=un_checked,1=checked';
            $table->tinyInteger('discount_type')->default(0)->comment='1=week_discount,2=day_discount';
            $table->bigInteger('day_week_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_discounts');
    }
}
