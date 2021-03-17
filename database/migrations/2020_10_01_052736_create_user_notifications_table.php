<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->tinyInteger('is_coach_appointment_reminder')->default(0)->comment='0=off,1=on';
            $table->tinyInteger('is_exercise_reminder')->default(0)->comment='0=off,1=on';
            $table->tinyInteger('is_chat_and_call')->default(0)->comment='0=off,1=on';
            $table->tinyInteger('is_you_received_a_follow_request')->default(0)->comment='0=off,1=on';
            $table->tinyInteger('is_your_follow_request_is_accepted')->default(0)->comment='0=off,1=on';
            $table->tinyInteger('is_someone_you_may_know')->default(0)->comment='0=off,1=on';
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
        Schema::dropIfExists('user_notifications');
    }
}
