<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftPlanDragDropStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_plan_drag_drop_structures', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_plan_drag_drop_structures');
    }
}
