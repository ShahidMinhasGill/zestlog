<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('exercise_id');
            $table->string('second_part_id');
            $table->string('name');
            $table->string('male_illustration')->nullable();
            $table->string('male_gif')->nullable();
            $table->string('male_video')->nullable();
            $table->string('female_illustration')->nullable();
            $table->string('female_gif')->nullable();
            $table->string('female_video')->nullable();
            $table->integer('body_part_id');
            $table->integer('target_muscle_id');
            $table->integer('equipment_id');
            $table->integer('training_form_id');
            $table->integer('discipline_id');
            $table->integer('level_id');
            $table->integer('priority_id');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('exercises');
    }
}
