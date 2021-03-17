<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingCoachingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_coaching_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('training_program_price_setup_id');
            $table->tinyInteger('type')->default(0)->comment='0=online-coaching,1=personal-training';
            $table->tinyInteger('is_listing')->default(0);
            $table->integer('session_length_id');
            $table->tinyInteger('price_changed')->nullable();
            $table->tinyInteger('price_checked')->nullable();
            $table->tinyInteger('rate_checked')->nullable();
            $table->string('price_up')->nullable();
            $table->string('price_down')->nullable();
            $table->string('rate_up')->nullable();
            $table->string('rate_down')->nullable();
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
        Schema::dropIfExists('training_coaching_sessions');
    }
}
