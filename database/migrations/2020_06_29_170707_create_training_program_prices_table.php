<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingProgramPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_program_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->default(1)->comment='1=training_program,2=diet_program,3=online_coaching,4=personal_training';
            $table->bigInteger('training_program_price_setup_id')->nullable();
            $table->bigInteger('training_plan_id')->nullable();
            $table->decimal('final_price_1')->nullable();
            $table->decimal('final_price_2')->nullable();
            $table->decimal('final_price_3')->nullable();
            $table->decimal('final_price_4')->nullable();
            $table->decimal('final_price_5')->nullable();
            $table->decimal('final_price_6')->nullable();
            $table->decimal('final_price_7')->nullable();
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
        Schema::dropIfExists('training_program_prices');
    }
}
