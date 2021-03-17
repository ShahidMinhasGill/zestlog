<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPlanTrainingCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_plan_training_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_plan_id')->unsigned();
            $table->bigInteger('day_id')->unsigned();
            $table->string('comment');
            $table->string('meta_data')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('client_plan_training_comments');
    }
}
