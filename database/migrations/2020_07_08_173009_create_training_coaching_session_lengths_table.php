<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingCoachingSessionLengthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_coaching_session_lengths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->default(3)->comment='3=online-coaching,4=personal-training';
            $table->string('value');
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
        Schema::dropIfExists('training_coaching_session_lengths');
    }
}
