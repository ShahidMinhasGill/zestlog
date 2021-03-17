<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('training_plan_id')->nullable();
            $table->text('pricing_discount_data')->nullable();
            $table->string('days_id')->nullable();
            $table->integer('week_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('change_training_plan_id')->nullable();
            $table->timestamp('starting_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('session_length')->nullable();
            $table->integer('training_session_location_id')->nullable();
            $table->string('training_session_location')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->tinyInteger('is_confirmed')->default(0)->comment='0=no,1=yes';

            $table->double('program_price')->nullable();
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
        Schema::dropIfExists('service_bookings');
    }
}
