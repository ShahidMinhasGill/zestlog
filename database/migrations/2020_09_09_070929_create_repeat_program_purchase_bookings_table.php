<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatProgramPurchaseBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeat_program_purchase_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('training_program_price_setup_id')->nullable();
            $table->tinyInteger('type')->nullable()->comment='1=training_program,2=diet,3=online_coaching,4=personal_training';
            $table->string('discount_1')->nullable();
            $table->string('discount_2')->nullable();
            $table->string('discount_3')->nullable();
            $table->string('discount_4')->nullable();
            $table->string('discount_5')->nullable();
            $table->string('discount_6')->nullable();
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
        Schema::dropIfExists('repeat_program_purchase_bookings');
    }
}
