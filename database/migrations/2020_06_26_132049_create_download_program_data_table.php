<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadProgramDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_program_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();
            $table->integer('week_number');
            $table->integer('year')->default(2020);
            $table->longText('plan_drag_drop_structures')->nullable();
            $table->longText('plan_training_overview_weeks')->nullable();
            $table->longText('download_program_data')->nullable();
            $table->longText('training_plan_structure')->nullable();
            $table->longText('plan_drag_drop_structures_straight')->nullable();
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
        Schema::dropIfExists('download_program_data');
    }
}
