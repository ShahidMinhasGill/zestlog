<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftPlanWeekTrainingSetupPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_plan_week_training_setup_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_week_training_setup_id')->unsigned();
            $table->integer('workout_type_set_id');
            $table->integer('workout_main_counter')->default(0);
            $table->integer('position')->default(0);
            $table->integer('exercise_set')->default(1);
            $table->tinyInteger('is_delete')->default(0);
            $table->tinyInteger('is_edit')->default(0);
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
        Schema::dropIfExists('draft_plan_week_training_setup_positions');
    }
}
