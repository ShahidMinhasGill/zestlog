<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftPlanTrainingOverviewWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_plan_training_overview_weeks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id')->unsigned();
            $table->bigInteger('day_id')->unsigned();
            $table->integer('day_plan_id')->unsigned();
            $table->integer('body_part_1')->nullable()->unsigned();
            $table->integer('body_part_2')->nullable()->unsigned();
            $table->integer('body_part_3')->nullable()->unsigned();
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
        Schema::dropIfExists('draft_plan_training_overview_weeks');
    }
}
