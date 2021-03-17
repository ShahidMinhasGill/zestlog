<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->tinyInteger('is_block_whole_week')->default(0)->comment='0=un_blocked,1=blocked';
            $table->tinyInteger('is_block_whole_day')->default(0)->comment='0=un_blocked,1=blocked';
            $table->integer('week_id')->nullable();
            $table->integer('day_id')->nullable();
            $table->integer('year')->nullable();
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
        Schema::dropIfExists('my_schedules');
    }
}
