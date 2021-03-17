<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftPlanWeekTrainingSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_plan_week_training_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id')->unsigned();
            $table->integer('day_id')->unsigned();
            $table->integer('plan_training_overview_week_id')->unsigned();
            $table->tinyInteger('warm_up')->default(0);
            $table->tinyInteger('main_workout')->default(0);
            $table->tinyInteger('cardio')->default(0);
            $table->tinyInteger('cool_down')->default(0);
            $table->tinyInteger('is_main_workout_top')->default(0);
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
        Schema::dropIfExists('draft_plan_week_training_setups');
    }
}
