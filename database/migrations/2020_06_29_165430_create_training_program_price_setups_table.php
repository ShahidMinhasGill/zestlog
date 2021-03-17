<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingProgramPriceSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_program_price_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('type')->default(1)->comment='1=training_program,2=diet_program,3=online_coaching,4=personal_training';
            $table->decimal('base_price')->nullable();
            $table->decimal('repeat_percentage_value')->nullable();
            $table->tinyInteger('is_auto_calculate_discount')->default(1)->comment='0=un_checked,1=checked';
            $table->tinyInteger('is_use_default_week_repeat')->default(1)->comment='0=un_checked,1=checked';
            $table->tinyInteger('is_use_default_length_program_booking')->default(1)->comment='0=un_checked,1=checked';
            $table->tinyInteger('is_use_default_repeat_purchase_booking')->default(1)->comment='0=un_checked,1=checked';
            $table->tinyInteger('length_online_coaching_session')->default(0);
            $table->tinyInteger('group_online_coaching')->default(0);
            $table->tinyInteger('pt_session_location')->default(0);
            $table->tinyInteger('length_pt_session')->default(0);
            $table->tinyInteger('group_personal_training')->default(0);
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
        Schema::dropIfExists('training_program_price_setups');
    }
}
