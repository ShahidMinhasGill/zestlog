<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanCreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('day_plan_id')->default(1);
            $table->integer('goal_id');
            $table->integer('training_day_id');
            $table->integer('training_age_id');
            $table->integer('age_category_id');
            $table->string('duration')->default('one week')->nullable();
            $table->enum('access_type', ['private', 'public']);
            $table->mediumText('description')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('status', ['0', '1', '2'])->comment='0=blocked,1=active';
            $table->tinyInteger('is_completed')->default(0);
            $table->tinyInteger('plan_day_id')->default(0);
            $table->tinyInteger('old_plan_id')->default(0);
            $table->tinyInteger('plan_type')->default(0)->comment='0=week-plan,1=day-plan';
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('day_plan_id')->references('id')->on('day_plans')
//                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('plan_training_overview_weeks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id')->unsigned();
            $table->bigInteger('day_id')->unsigned();
            $table->integer('day_plan_id')->unsigned();
            $table->integer('body_part_1')->nullable()->unsigned();
            $table->integer('body_part_2')->nullable()->unsigned();
            $table->integer('body_part_3')->nullable()->unsigned();
            $table->timestamps();

//            $table->foreign('plan_id')->references('id')->on('plans')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('day_id')->references('id')->on('days')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('day_plan_id')->references('id')->on('day_plans')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('body_part_1')->references('id')->on('body_parts')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('body_part_2')->references('id')->on('body_parts')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('body_part_3')->references('id')->on('body_parts')
//                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('plan_week_training_setups', function (Blueprint $table) {
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

//            $table->foreign('plan_id')->references('id')->on('plans')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('day_id')->references('id')->on('days')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('plan_training_overview_week_id')->references('id')->on('plan_training_overview_weeks')
//                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('plan_drag_drop_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id')->unsigned();
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
            $table->tinyInteger('is_delete')->default(0);
            $table->tinyInteger('is_edit')->default(0);
            $table->timestamps();

//            $table->foreign('plan_id')->references('id')->on('plans')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('day_id')->references('id')->on('days')
//                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_drag_drop_structures');
        Schema::dropIfExists('plan_week_training_setups');
        Schema::dropIfExists('plan_training_overview_weeks');
        Schema::dropIfExists('plans');
    }
}
