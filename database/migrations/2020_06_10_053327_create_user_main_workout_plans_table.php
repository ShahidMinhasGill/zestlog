<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMainWorkoutPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_main_workout_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();
            $table->integer('structure_id')->default(2);
            $table->integer('week_number')->default(1);
            $table->integer('year')->default(2020);
            $table->bigInteger('training_plan_id')->unsigned(); // This is drag and drop training plan structure id
            $table->integer('workout_set_type_id');
            $table->integer('position')->default(1);
            $table->integer('rep_id')->default(0);
            $table->string('rep_value')->nullable();
            $table->integer('rm_id')->default(0);
            $table->string('rm_value')->nullable();
            $table->string('rm_unit')->default('kg');
            $table->integer('duration_id')->default(0);
            $table->string('duration_value')->nullable();
            $table->integer('workout_counter')->default(0);
            $table->integer('workout_sub_counter')->default(0);
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
        Schema::dropIfExists('user_main_workout_plans');
    }
}
