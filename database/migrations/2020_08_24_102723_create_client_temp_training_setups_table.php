<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTempTrainingSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_temp_training_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_plan_id');
            $table->integer('day_id');
            $table->integer('structure_id');
            $table->integer('workout_main_counter');
            $table->integer('position');
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
        Schema::dropIfExists('client_temp_training_setups');
    }
}
