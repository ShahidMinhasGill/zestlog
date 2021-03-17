<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupOnlineCoachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_online_coachings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('training_program_price_setup_id');
            $table->tinyInteger('type')->default(0)->comment='0=online-coaching,1=personal-training';
            $table->tinyInteger('is_listing')->default(0);
            $table->integer('participant_count');
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
        Schema::dropIfExists('group_online_coachings');
    }
}
