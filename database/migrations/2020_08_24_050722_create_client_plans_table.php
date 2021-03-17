<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->integer('week_id')->nullable();
            $table->string('year')->nullable();
            $table->tinyInteger('is_publish')->default(0)->comment='0=un_publish,1=published';
            $table->timestamps();
        });

        Schema::create('client_plan_training_overview_weeks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_plan_id')->unsigned();
            $table->bigInteger('day_id')->unsigned();
            $table->integer('day_plan_id')->unsigned();
            $table->integer('body_part_1')->nullable()->unsigned();
            $table->integer('body_part_2')->nullable()->unsigned();
            $table->integer('body_part_3')->nullable()->unsigned();
            $table->timestamps();
        });

        Schema::create('client_plan_drag_drop_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_plan_id')->unsigned();
            $table->integer('day_id')->unsigned();
            $table->integer('structure_id');
            $table->bigInteger('exercise_id');
            $table->integer('workout_counter')->default(0);
            $table->integer('workout_sub_counter')->default(0);
            $table->integer('workout_set_type_id')->default(0);
            $table->string('workout_type')->nullable();
            $table->integer('position')->default(0);
            $table->bigInteger('position_id')->default(0);
            $table->integer('set_id')->nullable();
            $table->integer('rep_id')->nullable();
            $table->integer('duration_id')->nullable();
            $table->integer('note_id')->nullable();
            $table->integer('rm_id')->nullable();
            $table->integer('tempo_id')->nullable();
            $table->integer('rest_id')->nullable();
            $table->integer('form_id')->nullable();
            $table->integer('stage_id')->nullable();
            $table->integer('wr_id')->nullable();
            $table->timestamps();
        });
        Schema::create('client_plan_week_training_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_plan_id')->unsigned();
            $table->integer('day_id')->unsigned();
            $table->integer('client_plan_training_overview_week_id')->unsigned();
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
        Schema::dropIfExists('client_plan_week_training_setups');
        Schema::dropIfExists('client_plan_training_overview_weeks');
        Schema::dropIfExists('client_plans');
        Schema::dropIfExists('client_plan_drag_drop_structures');
    }
}
