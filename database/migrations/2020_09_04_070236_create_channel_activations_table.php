<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_activations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('verify_by_admin_id')->nullable();
            $table->tinyInteger('health_fitness')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('specialization_number')->default(1)->comment='1=specialization_1,2=specialization_2,3=specialization_3';
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->string('education_title')->nullable();
            $table->string('education_from')->nullable();
            $table->string('education_certificate')->nullable();
            $table->string('introduction')->nullable();
            $table->tinyInteger('is_verify')->default(0)->comment='0=no,1=yes';
            $table->tinyInteger('is_coach_channel')->default(0)->comment='0=no,1=yes';
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
        Schema::dropIfExists('channel_activations');
    }
}
